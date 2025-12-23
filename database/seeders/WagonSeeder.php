<?php

namespace Database\Seeders;

use App\Enums\WagonServiceClassEnum;
use App\Enums\WagonTypeEnum;
use App\Models\Seat;
use App\Models\Train;
use App\Models\Wagon;
use App\Models\WagonPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WagonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

        public function run(): void
    {
        $trains = Train::all();

        foreach ($trains as $train) {
            $capacity = rand(5, 20);
            $wagonsData = [];

            for ($i = 1; $i <= $capacity; $i++) {
                $wagonsData[] = [
                    'train_id' => $train->id,
                    'number' => $i,
                    'type' => WagonTypeEnum::cases()[array_rand(WagonTypeEnum::cases())]->value,
                    'service_class' => WagonServiceClassEnum::cases()[array_rand(WagonServiceClassEnum::cases())]->value,
                    'places' => 0,
                    'features' => json_encode([]),
                    'description' => '',
                    'seats_total' => 0,
                    'direction' => 'left',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Wagon::upsert(
                $wagonsData,
                ['train_id', 'number'],
                ['type', 'service_class', 'updated_at']
            );
        }
    }
}
