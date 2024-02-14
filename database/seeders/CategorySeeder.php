<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Auto Rescatador',
            'Medidor de Gases',
            'Equipo de Respiración Autónomo',
            'Lampara Minera',
        ];

        Category::factory()->createMany(
            array_map(fn ($category) => ['name' => $category], $categories)
        );
    }
}
