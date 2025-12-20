<?php

namespace Database\Seeders;

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
        Train::all()->each(function (Train $train) {

            $count = rand(5, 20);

            collect(range(1, $count))->each(function ($num) use ($train) {
                Wagon::factory()->create([
                    'train_id' => $train->id,
                    'number' => $num,
                ]);
            });

        });
    }
}
