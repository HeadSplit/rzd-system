@extends('layout.index')

@section('content')
    <div class="flex justify-center mt-24 px-4">
        <div class="w-full max-w-6xl bg-white rounded-xl shadow-lg p-8 space-y-12">

            @forelse($routes as $route)
                @php
                    $stations = $route->stations->sortBy('pivot_order')->values();
                    $start = $stations->first();
                    $end   = $stations->last();

                    $startDeparture = \Carbon\Carbon::parse($start->pivot->departure_time);
                    $endArrival     = \Carbon\Carbon::parse($end->pivot->arrival_time);

                    $duration = $startDeparture->diff($endArrival);
                @endphp

                <div class="bg-gray-50 border rounded-xl px-6 py-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('images/icons/train.svg')}}" class="w-6 h-6">
                            <h1 class="text-xl font-semibold">
                                {{ $route->name }}
                            </h1>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-center">
                            <div class="text-4xl font-semibold">
                                {{ $startDeparture->format('H:i') }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $start->name }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $startDeparture->format('d.m.Y') }}
                            </div>
                        </div>

                        <div class="flex-1 px-10">
                            <div class="flex items-center">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <div class="flex-1 h-px bg-red-500 mx-2"></div>
                                <svg class="w-6 h-6 text-red-500" fill="none"
                                     stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9 5l7 7-7 7" />
                                </svg>
                            </div>

                            <div class="text-center text-gray-500 text-sm mt-2">
                                {{ $duration->h }} ч {{ $duration->i }} мин
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="text-4xl font-semibold">
                                {{ $endArrival->format('H:i') }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $end->name }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $endArrival->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('routes.service', $route->id) }}"
                           class="inline-block px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Подробнее →
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 text-gray-500 text-lg">
                    Маршрутов не найдено
                </div>
            @endforelse
        </div>
    </div>
@endsection
