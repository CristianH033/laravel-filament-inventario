<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Mina la María',
            'Mina la Esperanza',
            'Mina Real',
            'Mina la Soledad',
            'Mina la Victoria',
        ];

        Location::factory()->createMany(
            array_map(fn ($location) => ['name' => $location], $locations)
        );
    }
}
