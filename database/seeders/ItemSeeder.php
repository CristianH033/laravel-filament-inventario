<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()
            ->count(1000)
            ->recycle(Device::all())
            ->recycle(Location::all())
            ->recycle(Status::all())
            ->create();
    }
}
