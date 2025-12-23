<?php

namespace Database\Seeders;

use App\Enums\SeatTypeEnum;
use App\Enums\WagonServiceClassEnum;
use App\Models\Seat;
use App\Models\Wagon;
use App\Services\WagonFeaturesService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function __construct(private WagonFeaturesService $wagonFeaturesService)
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wagon::chunk(100, function ($wagons) {
            $seatsData = [];

            foreach ($wagons as $wagon) {
                $wagonPrice = $wagon->wagonprice;

                $price = ($wagonPrice->min_price + $wagonPrice->max_price) / 2;

                $capacity = $this->wagonFeaturesService
                    ->getWagonData($wagon->service_class)['capacity'];

                for ($i = 1; $i <= $capacity; $i++) {
                    $seatsData[] = [
                        'wagon_id' => $wagon->id,
                        'number' => $i,
                        'type' => fake()->randomElement(array_column(SeatTypeEnum::cases(), 'value')),
                        'is_available' => true,
                        'price' => $price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($seatsData)) {
                Seat::upsert(
                    $seatsData,
                    ['wagon_id', 'number'],
                    ['price', 'is_available', 'updated_at']
                );
            }
        });
    }
}
