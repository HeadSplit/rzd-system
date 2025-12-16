<?php

namespace Database\Factories;

use App\Enums\WagonServiceClassEnum;
use App\Enums\WagonTypeEnum;
use App\Models\Train;
use App\Services\WagonFeaturesService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wagon>
 */
class WagonFactory extends Factory
{
    protected $wagonFeaturesService;

    public function __construct()
    {
        parent::__construct();
        $this->wagonFeaturesService = new WagonFeaturesService();
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $serviceClass = $this->faker->randomElement(WagonServiceClassEnum::cases());

        $wagonData = $this->wagonFeaturesService->getWagonData($serviceClass);

        $trainId = Train::inRandomOrder()->value('id');

        return [
            'train_id' => $trainId,
            'number' => $this->faker->numberBetween(1, 20),
            'type' => $this->faker->randomElement(array_column(WagonTypeEnum::cases(), 'value')),
            'service_class' => $serviceClass->value,
            'places' => $wagonData['capacity'],
            'features' => $wagonData['features'],
            'description' => $wagonData['description'],
            'seats_total' => $wagonData['capacity'],
            'direction' => $this->faker->randomElement(['left', 'right']),
        ];
    }
}
