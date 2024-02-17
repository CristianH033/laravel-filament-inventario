<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Historical;
use App\Models\Item;
use App\Models\Location;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoricalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Historical::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $item = Item::inRandomOrder()->first() ?? Item::factory()->create();

        return [
            'item_id' => $item->id,
            'change_log' => [
                'prev_state' => [
                    'serial' => $item->serial,
                    'internal_serial' => $item->internal_serial,
                    'device' => $item->device->display_name,
                    'location' => $item->location->name,
                    'status' => $item->status->name,
                    'comments' => $item->comments,
                ],
                'new_state' => [
                    'serial' => $this->faker->bothify('??-####?'),
                    'internal_serial' => $this->faker->bothify('??-####?'),
                    'device' => Device::inRandomOrder()->first()->display_name ?? Device::factory()->create()->display_name,
                    'location' => Location::inRandomOrder()->first()->name ?? Location::factory()->create()->name,
                    'status' => Status::inRandomOrder()->first()->name ?? Status::factory()->create()->name,
                    'comments' => $this->faker->text(),
                ],
            ],
            'change_date' => $this->faker->dateTime(),
            'reason' => $this->faker->text(),
        ];
    }
}
