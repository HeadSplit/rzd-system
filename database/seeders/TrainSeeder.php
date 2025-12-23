<?php

namespace Database\Seeders;

use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    public function run(): void
    {
        $stations = Station::orderBy('id')->pluck('id')->toArray();

        $data = [];

        for ($i = 0; $i < count($stations) - 1; $i++) {
            $data[] = [
                'number' => str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'name' => 'Поезд ' . ($i + 1),
                'start_station_id' => $stations[$i],
                'end_station_id' => $stations[$i + 1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $data[] = [
            'number' => str_pad(count($stations), 3, '0', STR_PAD_LEFT),
            'name' => 'Поезд ' . count($stations),
            'start_station_id' => $stations[count($stations) - 1],
            'end_station_id' => $stations[0],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Train::upsert(
            $data,
            ['start_station_id', 'end_station_id'],
            ['number', 'name', 'updated_at']
        );
    }
}
