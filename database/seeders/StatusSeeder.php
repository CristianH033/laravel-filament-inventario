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
            [
                'name' => 'Disponible',
                'color' => 'success',
            ],
            [
                'name' => 'En uso',
                'color' => 'info',
            ],
            [
                'name' => 'En mantenimiento',
                'color' => 'warning',
            ],
            [
                'name' => 'Dañado',
                'color' => 'danger',
            ],
            [
                'name' => 'Perdido',
                'color' => 'gray',
            ],
        ];

        Status::factory()->createMany($statuses);
    }
}
