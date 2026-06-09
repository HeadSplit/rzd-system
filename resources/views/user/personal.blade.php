@extends('layout.index')

@section('title', 'Личный кабинет')

@section('content')

    <div class="space-y-8">

        {{-- Профиль --}}
        <section class="bg-gradient-to-r from-red-700 to-red-500 rounded-3xl p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div>
                    <h1 class="text-3xl font-bold">
                        {{ auth()->user()->name }}
                    </h1>

                    <p class="text-red-100 mt-2">
                        Личный кабинет пассажира РЖД
                    </p>
                </div>

                <div class="flex gap-4">
                    <div class="bg-white/10 backdrop-blur rounded-2xl px-6 py-4">
                        <div class="text-2xl font-bold">
                            {{ $tickets->count() }}
                        </div>
                        <div class="text-sm text-red-100">
                            Билетов
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur rounded-2xl px-6 py-4">
                        <div class="text-2xl font-bold">
                            {{ $passangers->count() }}
                        </div>
                        <div class="text-sm text-red-100">
                            Пассажиров
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Данные пассажира --}}
            <div class="lg:col-span-1">

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                    <div class="bg-black px-6 py-4">
                        <h2 class="text-white text-lg font-semibold">
                            Данные пассажира
                        </h2>
                    </div>

                    @foreach($passangers as $passanger)

                        <div class="p-6 border-b last:border-b-0">

                            <div class="flex items-center gap-4 mb-4">

                                <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                                <span class="text-red-600 text-xl font-bold">
                                    {{ mb_substr($passanger->surname,0,1) }}
                                </span>
                                </div>

                                <div>
                                    <h3 class="font-semibold text-lg">
                                        {{ $passanger->surname }}
                                        {{ $passanger->name }}
                                    </h3>

                                    @if($passanger->has_patronymic)
                                        <p class="text-gray-500 text-sm">
                                            {{ $passanger->patronymic }}
                                        </p>
                                    @endif
                                </div>

                            </div>

                            <div class="space-y-3 text-sm">

                                <div>
                                <span class="text-gray-500">
                                    Дата рождения
                                </span>

                                    <div class="font-medium">
                                        {{ $passanger->birth_date }}
                                    </div>
                                </div>

                                <div>
                                <span class="text-gray-500">
                                    Документ
                                </span>

                                    <div class="font-medium">
                                        {{ $passanger->document }}
                                    </div>
                                </div>

                                <div>
                                <span class="text-gray-500">
                                    Серия и номер
                                </span>

                                    <div class="font-medium">
                                        {{ $passanger->series }}
                                        {{ $passanger->number }}
                                    </div>
                                </div>

                                <div>
                                <span class="text-gray-500">
                                    Пол
                                </span>

                                    <div class="font-medium">
                                        {{ $passanger->gender }}
                                    </div>
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- Билеты --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                    <div class="bg-black px-6 py-4">
                        <h2 class="text-white text-lg font-semibold">
                            Мои билеты
                        </h2>
                    </div>

                    <div class="p-6 space-y-6">

                        @forelse($tickets as $ticket)

                            <div class="border rounded-2xl hover:shadow-lg transition overflow-hidden">

                                <div class="bg-gray-50 p-5">

                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                                        <div class="flex items-center gap-6">

                                            <div>
                                                <div class="text-2xl font-bold">
                                                    {{ $ticket->from }}
                                                </div>

                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($ticket->from_date)->format('d.m.Y H:i') }}
                                                </div>
                                            </div>

                                            <div class="text-red-600 text-2xl">
                                                →
                                            </div>

                                            <div>
                                                <div class="text-2xl font-bold">
                                                    {{ $ticket->to }}
                                                </div>

                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($ticket->to_date)->format('d.m.Y H:i') }}
                                                </div>
                                            </div>

                                        </div>

                                        <div>
                                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                                            Активный билет
                                        </span>
                                        </div>

                                    </div>

                                </div>

                                <div class="p-5 grid md:grid-cols-3 gap-4 text-sm">

                                    <div>
                                        <div class="text-gray-500">
                                            Взрослые
                                        </div>

                                        <div class="font-semibold">
                                            {{ $ticket->adult_person }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">
                                            Дети
                                        </div>

                                        <div class="font-semibold">
                                            {{ $ticket->child_with_place + $ticket->child_without_place }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-gray-500">
                                            Дополнительно
                                        </div>

                                        <div class="font-semibold">
                                            @if($ticket->pets) 🐾 @endif
                                            @if($ticket->car) 🚗 @endif
                                            @if($ticket->motorcycle) 🏍️ @endif
                                        </div>
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-12">

                                <div class="text-5xl mb-4">
                                    🚆
                                </div>

                                <h3 class="text-xl font-semibold mb-2">
                                    У вас пока нет билетов
                                </h3>

                                <p class="text-gray-500">
                                    Приобретённые билеты будут отображаться здесь
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
