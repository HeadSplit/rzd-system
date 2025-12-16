<?php

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Train>
 */
class TrainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \DateMalformedStringException
     */
    public function definition(): array
    {
        $startId = Station::inRandomOrder()->value('id');

        $endId = Station::where('id', '!=', $startId)
            ->inRandomOrder()
            ->value('id');

        $departure = $this->faker->dateTimeBetween('now', '+14 days');

        $durationHours = $this->faker->numberBetween(1, 72);

        return [
            'name' => $this->faker->name(),
            'start_stantion_id' => $startId,
            'end_stantion_id' => $endId,
            'departure_time' => $departure,
            'arrival_time' => (clone $departure)->modify("+{$durationHours} hours"),
        ];
    }
}
