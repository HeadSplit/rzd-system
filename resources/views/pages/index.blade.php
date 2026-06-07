@extends('layout.index')
@section('title', 'Главная')

@section('content')

    {{-- HERO --}}
    <section class="bg-gradient-to-r from-red-600 to-red-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-6">
                Быстрый поиск билетов на поезд
            </h1>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">
                Удобное бронирование, лучшие маршруты и моментальное подтверждение.
            </p>
        </div>
    </section>


    {{-- ФОРМА ПОИСКА --}}
    <section class="-mt-16 relative z-10">
        <div class="max-w-7xl mx-auto px-6">

            @auth
                <form action="{{ route('trains.search') }}" method="GET">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 grid grid-cols-1 lg:grid-cols-4 gap-6">

                        {{-- Станции --}}
                        <div class="space-y-3">
                            <label class="text-sm font-semibold text-gray-600">Маршрут</label>
                            <div class="flex items-center gap-3">
                                <select name="from_station"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                    <option value="">Откуда</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>

                                <button type="button"
                                        class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full hover:bg-gray-200 transition">
                                    ⇄
                                </button>

                                <select name="to_station"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                    <option value="">Куда</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Даты --}}
                        <div class="space-y-3">
                            <label class="text-sm font-semibold text-gray-600">Дата поездки</label>
                            <input name="date_from" type="text"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500"
                                   placeholder="Туда">
                            <input name="date_to" type="text"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500"
                                   placeholder="Обратно">
                        </div>

                        {{-- Пассажиры --}}
                        <div class="space-y-3">
                            <label class="text-sm font-semibold text-gray-600">Пассажиры</label>
                            <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                <option>1 пассажир</option>
                                <option>2 пассажира</option>
                                <option>3 пассажира</option>
                                <option>4 пассажира</option>
                            </select>
                        </div>

                        {{-- Кнопка --}}
                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 rounded-lg text-lg transition shadow-lg">
                                Найти билеты
                            </button>
                        </div>

                    </div>
                </form>
            @endauth

            @guest
                <div class="text-center py-16">
                    <h2 class="text-3xl font-semibold text-gray-700">
                        Авторизуйтесь, чтобы начать поиск билетов
                    </h2>
                </div>
            @endguest

        </div>
    </section>


    {{-- ПРЕИМУЩЕСТВА --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Почему выбирают нас</h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="font-semibold text-xl mb-3">Быстро</h3>
                    <p class="text-gray-600">
                        Мгновенный поиск и бронирование билетов без очередей.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="font-semibold text-xl mb-3">Безопасно</h3>
                    <p class="text-gray-600">
                        Надёжные способы оплаты и защита данных.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🌍</div>
                    <h3 class="font-semibold text-xl mb-3">По всей стране</h3>
                    <p class="text-gray-600">
                        Доступ к тысячам маршрутов и направлений.
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- ПОПУЛЯРНЫЕ НАПРАВЛЕНИЯ --}}
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Популярные направления</h2>

            <div class="grid md:grid-cols-4 gap-6">
                @foreach(['Москва — Санкт-Петербург','Казань — Москва','Сочи — Краснодар','Екатеринбург — Тюмень'] as $route)
                    <div class="bg-white rounded-xl shadow p-6 hover:shadow-xl transition cursor-pointer">
                        <h3 class="font-semibold text-lg mb-2">{{ $route }}</h3>
                        <p class="text-gray-500 text-sm">от 1 250 ₽</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- FAQ --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Частые вопросы</h2>

            <div class="space-y-6">
                <div>
                    <h4 class="font-semibold mb-2">Можно ли вернуть билет?</h4>
                    <p class="text-gray-600">Да, возврат возможен согласно правилам перевозчика.</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-2">Когда приходит билет?</h4>
                    <p class="text-gray-600">Сразу после оплаты билет отправляется на вашу почту.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
