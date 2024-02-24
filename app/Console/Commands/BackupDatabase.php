<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--path= : The path where backup will be saved}
    {--filename= : The name of backup file}
    {--compress : Compress backup file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = $this->option('filename') ?: 'backup_'.date('Y_m_d_H_i_s').'.sql';
        $path = $this->option('path') ?: '';
        $compress = $this->option('compress');

        $command = $this->dumpCommand();

        $backupFile = $path.'/'.$filename;

        $content = (string) shell_exec($command);

        Storage::disk('backups')->put($backupFile, $content);

        if ($compress) {
            $this->compressFile($backupFile);
        }

        $this->info("Database backup completed. Backup file: {$backupFile}");
    }

    protected function dumpCommand(): string
    {
        $uname = php_uname('s');

        if ($uname === 'Linux') {
            return 'sqlite3 '.database_path('database.sqlite').' .dump';
        } elseif ($uname === 'Darwin') {
            return 'sqlite3 '.database_path('database.sqlite').' .dump';
        } else {
            return 'sqlite3 '.database_path('database.sqlite').' .dump';
        }
    }

    protected function compressFile(string $path): void
    {
        $compressedFile = $path.'.gz';

        $content = (string) Storage::disk('backups')->get($path);

        $gzContent = (string) gzencode($content);

        Storage::disk('backups')->put($compressedFile, $gzContent);

        Storage::disk('backups')->delete($path);
    }
}
