@extends('layout.index')

@section('title', 'Билет')

@section('content')

    <div class="max-w-5xl mx-auto space-y-8">

        <div class="bg-gradient-to-r from-red-700 to-red-500 rounded-3xl p-8 text-white shadow-xl">

            <div class="flex justify-between items-center">

                <div>
                    <h1 class="text-3xl font-bold">
                        Электронный билет
                    </h1>

                    <p class="text-red-100 mt-2">
                        Информация о поездке
                    </p>
                </div>

                <span class="bg-white/20 px-5 py-2 rounded-2xl">
                Активный билет
            </span>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

            <div class="bg-black px-8 py-5 text-white text-xl font-semibold">
                Маршрут
            </div>

            <div class="p-8">

                <div class="flex items-center justify-between">

                    <div>
                        <div class="text-4xl font-bold">
                            {{ $ticket->fromStation->name }}
                        </div>

                        <div class="text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($ticket->from_date)->format('d.m.Y H:i') }}
                        </div>
                    </div>

                    <div class="text-red-600 text-5xl">
                        →
                    </div>

                    <div class="text-right">
                        <div class="text-4xl font-bold">
                            {{ $ticket->toStation->name }}
                        </div>

                        <div class="text-gray-500 mt-2">
                            {{ \Carbon\Carbon::parse($ticket->to_date)->format('d.m.Y H:i') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-8">

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                <div class="bg-black px-6 py-4 text-white text-lg font-semibold">
                    Пассажиры
                </div>

                <div class="p-6 space-y-4">

                    <div>
                        <div class="text-gray-500">
                            Взрослые
                        </div>

                        <div class="font-semibold text-lg">
                            {{ $ticket->adult_person }}
                        </div>
                    </div>

                    <div>
                        <div class="text-gray-500">
                            Дети с местом
                        </div>

                        <div class="font-semibold text-lg">
                            {{ $ticket->child_with_place }}
                        </div>
                    </div>

                    <div>
                        <div class="text-gray-500">
                            Дети без места
                        </div>

                        <div class="font-semibold text-lg">
                            {{ $ticket->child_without_place }}
                        </div>
                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                <div class="bg-black px-6 py-4 text-white text-lg font-semibold">
                    Дополнительно
                </div>

                <div class="p-6 space-y-4">

                    <div>
                        Перевозка животных:
                        <span class="font-semibold">
                        {{ $ticket->pets ? 'Да' : 'Нет' }}
                    </span>
                    </div>

                    <div>
                        Автомобиль:
                        <span class="font-semibold">
                        {{ $ticket->car ? 'Да' : 'Нет' }}
                    </span>
                    </div>

                    <div>
                        Мотоцикл:
                        <span class="font-semibold">
                        {{ $ticket->motorcycle ? 'Да' : 'Нет' }}
                    </span>
                    </div>

                </div>

            </div>

        </div>

        <div>
            <a href="{{ route('users.personal') }}"
               class="bg-gray-800 hover:bg-black text-white px-6 py-3 rounded-2xl">
                ← Вернуться в личный кабинет
            </a>
        </div>

    </div>

@endsection
