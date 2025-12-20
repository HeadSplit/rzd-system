@extends('layout.index')
@section('content')

    <div class="flex justify-center mt-24 px-4">
        <div class="w-full max-w-6xl bg-white rounded-xl shadow-lg p-8">

            <form action="{{ route('trains.search') }}" method="GET">
                <h2 class="text-2xl font-semibold mb-6">Результаты поиска</h2>

                @if($routes->isEmpty())
                    <p class="text-gray-600">По вашему запросу ничего не найдено.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($routes as $route)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <h3 class="text-lg font-semibold mb-2">{{ $route->train->name }}</h3>
                                <p class="text-gray-700 mb-2">
                                    Маршрут:
                                    @foreach($route->stations->sortBy('order') as $station)
                                        {{ $station->name }}@if(!$loop->last) → @endif
                                    @endforeach
                                </p>
                                <p class="text-gray-600 mb-2">
                                    Отправление: {{ $route->stations->first()->departure_time }}
                                    @if($route->stations->count() > 1)
                                        / Прибытие: {{ $route->stations->last()->arrival_time }}
                                    @endif
                                </p>

                                <div class="mt-3 flex gap-2">
                                    @foreach($route->stations->sortBy('order') as $station)
                                        <div class="flex-1 text-center border rounded py-1 px-2 text-sm bg-gray-50">
                                            {{ $station->name }}<br>
                                            {{ $station->arrival_time }} → {{ $station->departure_time }}
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="mt-4 inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg text-center w-full">
                                    Забронировать
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </form>

        </div>
    </div>

@endsection
