<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->unique()->bothify('??-####?'),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'description' => $this->faker->text(),
        ];
    }
}
