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
        Wagon::chunk(100, function ($wagons) {
            $data = [];

            foreach ($wagons as $wagon) {
                $serviceClass = $wagon->service_class;
                $priceRange = $serviceClass->getBasePriceRange();

                $minPrice = mt_rand($priceRange[0] * 100, $priceRange[1] * 100) / 100;
                $maxPrice = mt_rand($minPrice * 100, ($priceRange[1] * 1.5) * 100) / 100;

                $data[] = [
                    'wagon_id' => $wagon->id,
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            WagonPrice::upsert(
                $data,
                ['wagon_id'],
                ['min_price', 'max_price', 'updated_at']
            );
        });
    }
}
