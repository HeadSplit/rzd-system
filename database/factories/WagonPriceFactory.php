<?php

namespace Database\Factories;

use App\Enums\WagonServiceClassEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
Use App\Models\Wagon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WagonPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'min_price' => 8000,
            'max_price' => 15000,
        ];
    }
}
