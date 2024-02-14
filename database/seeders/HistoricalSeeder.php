<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Historical;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Database\Seeder;

class HistoricalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Historical::factory()
            ->count(5000)
            ->recycle(Item::all())
            ->recycle(Device::all())
            ->recycle(Location::all())
            ->recycle(Status::all())
            ->create();
    }
}
