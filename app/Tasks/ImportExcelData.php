<?php

namespace App\Tasks;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Device;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use DB;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class ImportExcelData
{
    private Validation $validator;

    public function __construct()
    {
        $this->validator = new Validation();
    }

    public function import(string $excelFile): int
    {
        $rawData = Excel::toCollection(new stdClass(), $excelFile);

        $data = $this->transformData($rawData);

        $this->validator->validate($data, [
            // 'COMMENT' => [Validation::VALIDATE_EMPTY => []],
            'CATEGORY' => [Validation::VALIDATE_EMPTY => []],
            'BRAND' => [Validation::VALIDATE_EMPTY => []],
            'MODEL' => [
                Validation::VALIDATE_EMPTY => [],
                Validation::VALIDATE_DUPLICATE => ['BRAND', 'CATEGORY'],
            ],
            'SERIAL' => [
                Validation::VALIDATE_EMPTY => [],
                Validation::VALIDATE_DUPLICATE => [],
            ],
            'INTERNAL_SERIAL' => [
                Validation::VALIDATE_EMPTY => [],
                Validation::VALIDATE_DUPLICATE => [],
            ],
            'STATUS' => [
                Validation::VALIDATE_EMPTY => [],
            ],
            'LOCATION' => [
                Validation::VALIDATE_EMPTY => [],
            ],
            'OWNED_BY' => [
                Validation::VALIDATE_EMPTY => [],
            ],
        ]);

        DB::transaction(function () use ($data) {
            $this->importBrands($data);
            $this->importStatuses($data);
            $this->importCategories($data);
            $this->importLocations($data);
            $this->importDevices($data);
            $this->importItems($data);
        });

        return 0;
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importBrands(Collection $data): void
    {
        $brands = $data->pluck('BRAND')->unique();

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['name' => $brand]);
        }
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importStatuses(Collection $data): void
    {
        $statuses = $data->pluck('STATUS')->unique();

        foreach ($statuses as $status) {
            Status::firstOrCreate([
                'name' => $status,
                'color' => 'success',
            ]);
        }
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importCategories(Collection $data): void
    {
        $categories = $data->pluck('CATEGORY')->unique();

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importLocations(Collection $data): void
    {
        $locations = $data->pluck('LOCATION')->unique();
        $owners = $data->pluck('OWNED_BY')->unique();

        $allLocations = $locations->merge($owners)->unique();

        foreach ($allLocations as $location) {
            Location::firstOrCreate(['name' => $location]);
        }
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importDevices(Collection $data): void
    {
        $devices = $data->unique(function (Collection $device) {
            return $device['BRAND'].$device['CATEGORY'].$device['MODEL'];
        });

        $devices->each(function (Collection $device) {
            $brand = Brand::firstOrCreate(['name' => $device->get('BRAND')]);
            $category = Category::firstOrCreate(['name' => $device->get('CATEGORY')]);

            Device::firstOrCreate([
                'model' => $device->get('MODEL'),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
            ]);
        });
    }

    /**
     * @param  Collection<int, Collection<int|string, bool|int|string|null>>  $data
     */
    private function importItems(Collection $data): void
    {
        $data->each(function (Collection $record) {
            $status = Status::firstOrCreate(['name' => $record->get('STATUS')]);
            $owner = Location::firstOrCreate(['name' => $record->get('OWNED_BY')]);
            $location = Location::firstOrCreate(['name' => $record->get('LOCATION')]);
            $device = Device::firstOrCreate(['model' => $record->get('MODEL')]);

            Item::firstOrCreate([
                'serial' => $record->get('SERIAL'),
                'internal_serial' => $record->get('INTERNAL_SERIAL'),
                'device_id' => $device->id,
                'owner_id' => $owner->id,
                'location_id' => $location->id,
                'status_id' => $status->id,
                'comments' => $record->get('COMMENTS'),
            ]);
        });
    }

    /**
     * @param  Collection<int, Collection<int, Collection<int, int|string|null|bool>>>  $data
     * @return Collection<int, Collection<int|string, int|string|null|bool>>
     */
    private function transformData(Collection $data): Collection
    {
        if (is_null($data[0])) {
            throw new Exception('Excel data is empty', 1);
        }

        $excelData = $data[0];

        if (is_null($excelData[0])) {
            throw new Exception('Excel data is empty', 1);
        }

        $headers = $excelData[0];
        $rows = $excelData->slice(1)->values();

        $transformedCollection = $rows->map(
            function (Collection $row) use ($headers) {

                return $headers->combine($row)->flatMap(
                    function ($value, $key) {
                        /**
                         * @var (string|int) $typedKey
                         */
                        $typedKey = match (true) {
                            is_int($key) => (int) $key,
                            is_string($key) => (string) $key,
                            // default => $value
                        };

                        /**
                         * @var (string|int|bool|null) $typedValue
                         */
                        $typedValue = match ($value) {
                            is_int($value) => (int) $value,
                            is_string($value) => (string) $value,
                            is_bool($value) => (bool) $value,
                            is_null($value) => null,
                            default => $value,
                        };

                        return [$typedKey => $typedValue];
                    }
                );
            }
        );

        return $transformedCollection;
    }
}
