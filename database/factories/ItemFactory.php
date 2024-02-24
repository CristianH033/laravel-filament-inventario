<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'serial' => $this->faker->unique()->bothify('??-####?'),
            'internal_serial' => $this->faker->unique()->bothify('??-####?'),
            'device_id' => Device::factory(),
            'owner_id' => Location::factory(),
            'location_id' => Location::factory(),
            'status_id' => Status::factory(),
            'comments' => $this->faker->text(),
        ];
    }
}
