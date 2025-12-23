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
        $stations = Station::orderBy('id')->pluck('id');

        Train::chunk(50, function ($trains) use ($stations) {
            foreach ($trains as $train) {
                $routesData = [];
                $totalStations = min(15, $stations->count());
                $path = $stations->take($totalStations);
                $chunks = $path->chunk(5);
                $time = now()->startOfDay()->addHours(6);

                foreach ($chunks as $index => $chunk) {
                    if ($index > 0) {
                        $chunk->prepend($chunks[$index - 1]->last());
                    }

                    $routesData[] = [
                        'train_id' => $train->id,
                        'name' => 'Маршрут ' . ($index + 1),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Route::upsert($routesData, ['train_id', 'name'], ['updated_at']);
                $routes = Route::where('train_id', $train->id)->get()->keyBy('name');

                foreach ($chunks as $index => $chunk) {
                    $route = $routes['Маршрут ' . ($index + 1)];
                    $rows = [];
                    $currentTime = $time->copy();

                    foreach ($chunk->values() as $order => $stationId) {
                        $arrival = $currentTime->copy();
                        $departure = $arrival->copy()->addMinutes(60);

                        $rows[] = [
                            'route_id' => $route->id,
                            'station_id' => $stationId,
                            'order' => $order + 1,
                            'arrival_time' => $arrival,
                            'departure_time' => $departure,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $currentTime->addMinutes(30);
                    }

                    DB::table('route_stations')->upsert(
                        $rows,
                        ['route_id', 'station_id'],
                        ['order', 'arrival_time', 'departure_time', 'updated_at']
                    );
                }
            }
        });
    }
}
