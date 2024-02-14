<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            '3M',
            'MSA',
            'Draeger',
            'Honeywell',
        ];

        Brand::factory()->createMany(
            array_map(fn ($brand) => ['name' => $brand], $brands)
        );
    }
}
