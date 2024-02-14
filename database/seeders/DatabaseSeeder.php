<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            StatusSeeder::class,
            LocationSeeder::class,
            DeviceSeeder::class,
            ItemSeeder::class,
            HistoricalSeeder::class,
        ]);
    }
}
