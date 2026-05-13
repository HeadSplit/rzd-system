<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteStationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = Station::pluck('id');

        Train::chunk(50, function ($trains) use ($stations) {
            foreach ($trains as $train) {

                $totalStations = $stations->count();

                $length = rand(8, min(20, $totalStations));

                $start = rand(0, $totalStations - $length);

                $path = $stations
                    ->slice($start, $length)
                    ->values();

                $route = Route::updateOrCreate(
                    [
                        'train_id' => $train->id,
                    ],
                    [
                        'name' => 'Маршрут поезда #' . $train->number,
                    ]
                );

                $rows = [];

                $currentTime = now()
                    ->addDays(rand(0, 30))
                    ->setHour(rand(0, 23))
                    ->setMinute([0, 15, 30, 45][rand(0, 3)]);

                foreach ($path as $order => $stationId) {

                    $arrival = $currentTime->copy();

                    $departure = $arrival
                        ->copy()
                        ->addMinutes(rand(5, 40));

                    $rows[] = [
                        'route_id' => $route->id,
                        'station_id' => $stationId,
                        'order' => $order + 1,
                        'arrival_time' => $arrival,
                        'departure_time' => $departure,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $currentTime = $departure
                        ->copy()
                        ->addHours(rand(2, 12));
                }

                DB::table('route_stations')->upsert(
                    $rows,
                    ['route_id', 'station_id'],
                    [
                        'order',
                        'arrival_time',
                        'departure_time',
                        'updated_at'
                    ]
                );
            }
        });
    }
}
