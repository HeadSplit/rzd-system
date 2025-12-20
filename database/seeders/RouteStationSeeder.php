<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Train::all()->each(function ($train) {

            $name = Station::find($train->start_station_id)->name
                . ' — ' .
                Station::find($train->end_station_id)->name;

            $route = Route::create([
                'train_id' => $train->id,
                'name' => $name
            ]);

            $stations = [
                $train->start_station_id,
                $train->end_station_id
            ];

            $currentTime = time();

            foreach ($stations as $index => $stationId) {
                $travelHours = rand(1, 3);
                $arrival = $index === 0 ? $currentTime : $currentTime + $travelHours * 3600;
                $stopMinutes = rand(5, 15);
                $departure = $arrival + $stopMinutes * 60;

                RouteStation::create([
                    'route_id' => $route->id,
                    'station_id' => $stationId,
                    'order' => $index + 1,
                    'arrival_time' => date('H:i:s', $arrival),
                    'departure_time' => date('H:i:s', $departure)
                ]);

                $currentTime = $departure;
            }
        });
    }
}
