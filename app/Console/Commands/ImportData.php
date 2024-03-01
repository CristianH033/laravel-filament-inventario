<?php

namespace App\Console\Commands;

use App\Tasks\ImportExcelData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-data {file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from an Excel file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (! $filePath) {
            $filePath = 'data.xlsx';
        }

        if (! Storage::disk('imports')->exists($filePath)) {
            $this->error('File not found: '.$filePath);

            return 1;
        }

        $pathToFile = Storage::disk('imports')->path($filePath);

        $this->fileValidation($pathToFile)->validate();
        $this->structureValidation($pathToFile)->validate();

        // Call your import methods here
        try {
            (new ImportExcelData())->import($pathToFile);
        } catch (\Throwable $th) {
            //throw $th;
            $this->error($th->getMessage());

            return 1;
        }

        $this->info('Data imported successfully!');

        return 0;
    }

    public function fileValidation(string $filePath): ValidationObject
    {
        $val = new ValidationObject($this);

        $mimeType = (string) File::mimeType($filePath);
        $extension = (string) File::extension($filePath);

        $mimetypes = collect(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']);
        $extensions = collect(['xlsx', 'xls']);

        if (! $mimetypes->contains($mimeType)) {
            $val->errorMessage = 'The file is not an Excel file (xlsx or xls).';
            $val->success = false;
        }

        if (! $extensions->contains($extension)) {
            $val->errorMessage = 'The file must be an Excel file (xlsx or xls).';
            $val->success = false;
        }

        try {
            Excel::toArray(new stdClass(), $filePath);
        } catch (\Exception $e) {
            $val->errorMessage = 'The Excel file is invalid or corrupt.';
            $val->success = false;
        }

        return $val;
    }

    public function structureValidation(string $filePath): ValidationObject
    {
        $validationObject = new ValidationObject($this);

        $excelData = Excel::toArray(new stdClass(), $filePath);

        $requiredColumns = [
            'CATEGORY',
            'BRAND',
            'MODEL',
            'SERIAL',
            'INTERNAL_SERIAL',
            'COMMENTS',
            'STATUS',
            'OWNED_BY',
            'LOCATION',
        ];

        $columns = $excelData[0][0] ?? [];

        if (count(array_diff($requiredColumns, $columns)) > 0) {
            $validationObject->success = false;
            $validationObject->errorMessage = 'The Excel file does not have the required columns.';
        }

        return $validationObject;
    }
}

class ValidationObject
{
    public bool $success = true;

    public string $message = '';

    public string $errorMessage = '';

    protected Command $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function validate(): void
    {
        if (! $this->success) {
            $this->command->error($this->errorMessage);
            exit(1);
        }
    }
}
