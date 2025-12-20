<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteStation;
use App\Models\Station;
use App\Models\Train;
use Carbon\Carbon;
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
                . ' — ' . Station::find($train->end_station_id)->name;

            $route = Route::create([
                'train_id' => $train->id,
                'name' => $name
            ]);

            $stations = [
                $train->start_station_id,
                $train->end_station_id
            ];

            $currentDateTime = Carbon::now()->addDays(rand(0, 14))->setTime(rand(6, 22), rand(0, 59));

            foreach ($stations as $index => $stationId) {
                $travelHours = rand(1, 3);
                $arrival = $currentDateTime;
                $departure = (clone $arrival)->addMinutes(rand(5, 15));

                RouteStation::create([
                    'route_id' => $route->id,
                    'station_id' => $stationId,
                    'order' => $index + 1,
                    'arrival_time' => $arrival->format('Y-m-d H:i:s'),
                    'departure_time' => $departure->format('Y-m-d H:i:s')
                ]);

                $currentDateTime = (clone $departure)->addHours($travelHours);
            }
        });
    }
}
