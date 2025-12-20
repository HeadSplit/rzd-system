<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Train;
use App\Models\Wagon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = Station::all()->pluck('id')->toArray();
        shuffle($stations);

        for ($i = 0; $i < count($stations) - 1; $i++) {
            Train::create([
                'name' => 'Поезд ' . ($i + 1),
                'start_station_id' => $stations[$i],
                'end_station_id' => $stations[$i + 1],
            ]);
        }

        Train::create([
            'name' => 'Поезд ' . count($stations),
            'start_station_id' => $stations[count($stations) - 1],
            'end_station_id' => $stations[0],
        ]);
    }
}
