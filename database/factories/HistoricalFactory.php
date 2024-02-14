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
            'changes' => [
                'prev_state' => [
                    'serial' => $item->serial,
                    'internal_serial' => $item->internal_serial,
                    'device_id' => $item->device_id,
                    'location_id' => $item->location_id,
                    'status_id' => $item->status_id,
                    'comments' => $item->comments,
                ],
                'new_state' => [
                    'serial' => $this->faker->bothify('??-####?'),
                    'internal_serial' => $this->faker->bothify('??-####?'),
                    'device_id' => Device::factory(),
                    'location_id' => Location::factory(),
                    'status_id' => Status::factory(),
                    'comments' => $this->faker->text(),
                ],
            ],
            'change_date' => $this->faker->dateTime(),
            'reason' => $this->faker->text(),
        ];
    }
}
