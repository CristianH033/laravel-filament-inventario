<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Disponible',
            'En uso',
            'En mantenimiento',
            'Dañado',
            'Perdido',
        ];

        Status::factory()->createMany(
            array_map(fn ($status) => ['name' => $status], $statuses)
        );
    }
}
