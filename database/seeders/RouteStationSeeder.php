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
        $stations = Station::pluck('id')->shuffle()->values();

        DB::transaction(function () use ($stations) {

            Train::all()->each(function ($train) use ($stations) {

                $routesCount = rand(3, 6);

                $totalStations = rand(15, 30);
                $path = $stations->take($totalStations)->values();

                $chunks = $path->chunk(5)->values();

                $time = now()->startOfDay()->addHours(rand(0, 6));

                foreach ($chunks as $index => $chunk) {

                    if ($index > 0) {
                        $chunk->prepend($chunks[$index - 1]->last());
                    }

                    $route = Route::create([
                        'train_id' => $train->id,
                        'name' => 'Маршрут ' . ($index + 1),
                    ]);

                    $rows = [];

                    foreach ($chunk->values() as $order => $stationId) {

                        $arrival = $time->copy();
                        $departure = $arrival->copy()->addMinutes(rand(60, 300));

                        $rows[] = [
                            'route_id' => $route->id,
                            'station_id' => $stationId,
                            'order' => $order + 1,
                            'arrival_time' => $arrival,
                            'departure_time' => $departure,
                        ];

                        $time->addMinutes(rand(20, 60));
                    }

                    DB::table('route_stations')->insert($rows);
                }
            });
        });
    }
}
