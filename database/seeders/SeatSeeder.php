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
        Wagon::all()->each(function (Wagon $wagon)  {

            $wagonPrice = $wagon->wagonprice;

            $price = fake()->randomFloat(
                2,
                min($wagonPrice->min_price, $wagonPrice->max_price),
                max($wagonPrice->min_price, $wagonPrice->max_price)
            );

            if ($wagon->seats()->exists()) {
                return;
            }

            $capacity = $this->wagonFeaturesService
                ->getWagonData(WagonServiceClassEnum::tryFrom($wagon->service_class))
            ['capacity'];

            for ($i = 1; $i <= $capacity; $i++) {
                Seat::create([
                    'wagon_id' => $wagon->id,
                    'number' => $i,
                    'type' => fake()->randomElement(array_column(SeatTypeEnum::cases(), 'value')),
                    'is_available' => true,
                    'price' => $price
                    ]);
            }
        });
    }

}
