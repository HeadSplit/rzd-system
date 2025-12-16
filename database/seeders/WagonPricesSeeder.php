<?php

namespace Database\Seeders;

use App\Enums\WagonServiceClassEnum;
use App\Models\Wagon;
use App\Models\WagonPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WagonPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wagon::all()->each(function (Wagon $wagon) {
            $serviceClass = $wagon->service_class;
            $priceRange = WagonServiceClassEnum::tryFrom($serviceClass)->getBasePriceRange();

            WagonPrice::factory()
                ->for($wagon)
                ->state(function () use ($priceRange) {
                    $minPrice = fake()->randomFloat(2, $priceRange[0], $priceRange[1]);
                    $maxPrice = fake()->randomFloat(2, $minPrice, $priceRange[1] * 1.5);

                    return [
                        'min_price' => $minPrice,
                        'max_price' => $maxPrice,
                    ];
                })
                ->create();
        });
    }
}
