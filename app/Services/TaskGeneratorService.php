<?php


namespace App\Services;

use App\Models\Route;
use App\Models\Task;
use App\Models\User;
use App\Enums\WagonServiceClassEnum;
use Illuminate\Support\Carbon;

class TaskGeneratorService
{
    public function generateFor(User $user): Task
    {
        $route = Route::with([
            'stations' => function ($q) {
                $q->withPivot(['arrival_time', 'departure_time'])
                    ->orderBy('route_stations.order');
            },
            'train.wagons'
        ])
            ->has('stations', '>=', 2)
            ->inRandomOrder()
            ->firstOrFail();

        $train = $route->train;

        if (!$train || $train->wagons->isEmpty()) {
            throw new \RuntimeException('У поезда нет вагонов');
        }

        $stations = $route->stations->values();

        $fromIndex = rand(0, $stations->count() - 2);
        $toIndex = rand($fromIndex + 1, $stations->count() - 1);

        $fromStation = $stations[$fromIndex];
        $toStation = $stations[$toIndex];

        $departureTime = $fromStation->pivot->departure_time;
        $arrivalTime = $toStation->pivot->arrival_time;

        $wagon = $train->wagons->random();

        $wagonEnum = $wagon->service_class instanceof WagonServiceClassEnum
            ? $wagon->service_class
            : WagonServiceClassEnum::from($wagon->service_class);

        $wagon->loadMissing('seats');

        if ($wagon->seats->count() < 2) {
            throw new \RuntimeException('Недостаточно мест в вагоне');
        }

        $seats = $wagon->seats
            ->random(2)
            ->sortBy('number')
            ->pluck('number')
            ->values()
            ->toArray();

        $correct = [
            'route_id' => $route->id,
            'train_id' => $train->id,

            'from_station_id' => $fromStation->id,
            'to_station_id' => $toStation->id,

            'from' => $fromStation->name,
            'to' => $toStation->name,

            'departure_time' => $departureTime,
            'arrival_time' => $arrivalTime,

            'wagon_id' => $wagon->id,
            'wagon_class' => $wagonEnum->value,

            'seats' => $seats,

            'passanger' => [
                'surname' => fake()->lastName(),
                'name' => fake()->firstName(),
                'patronymic' => fake()->firstName(),
            ],

            'document' => [
                'type' => array_rand(\App\Models\Passanger::DOCUMENT_TYPES),
                'series' => (string) rand(1000, 9999),
                'number' => (string) rand(100000, 999999),
            ],
        ];

        return Task::updateOrCreate(
            ['user_id' => $user->id],
            [
                'description' => $this->buildDescription($correct),
                'correct_answers' => $correct,
                'status' => 'pending',
            ]
        );
    }

    private function buildDescription(array $c): string
    {
        $wagon = WagonServiceClassEnum::from($c['wagon_class']);

        return sprintf(
            "Приобретите билет на поезд №%d по маршруту %s → %s. Отправление: %s, прибытие: %s. Выберите вагон класса \"%s\" и места %s. Пассажир: %s %s %s, документ: %s серии %s номер %s.",
            $c['train_id'],
            $c['from'],
            $c['to'],
            Carbon::parse($c['departure_time'])->format('d.m.Y H:i'),
            Carbon::parse($c['arrival_time'])->format('d.m.Y H:i'),
            $wagon->label(),
            implode(', ', $c['seats']),
            $c['passanger']['surname'],
            $c['passanger']['name'],
            $c['passanger']['patronymic'],
            \App\Models\Passanger::DOCUMENT_TYPES[$c['document']['type']] ?? '',
            $c['document']['series'],
            $c['document']['number'],
        );
    }
}
