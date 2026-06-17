@extends('layout.index')
@section('title', 'Главная')

@section('content')

    <section class="bg-gradient-to-r from-red-600 to-red-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-6">Быстрый поиск билетов на поезд</h1>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">Удобное бронирование, лучшие маршруты и моментальное подтверждение.</p>
        </div>
    </section>

    <section class="-mt-16 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            @auth
                <form action="{{ route('trains.search') }}" method="GET">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                            <div class="space-y-3">
                                <label class="text-sm font-semibold text-gray-600">Маршрут</label>
                                <div class="flex items-center gap-3">
                                    <select name="from_station" id="from_station"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                        <option value="">Откуда</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="swap-stations"
                                            class="w-12 h-12 flex items-center justify-center bg-gray-100 rounded-full hover:bg-gray-200 transition">⇄</button>
                                    <select name="to_station" id="to_station"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                        <option value="">Куда</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-sm font-semibold text-gray-600">Дата поездки</label>
                                <input name="date_from" type="date"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500" required>
                                <input name="date_to" type="date"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500" required>
                            </div>
                            <div class="space-y-3">
                                <label class="text-sm font-semibold text-gray-600">Пассажиры</label>
                                <select name="passengers_count" id="passengers-dropdown"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500">
                                    <option value="1">1 пассажир</option>
                                    <option value="2">2 пассажира</option>
                                    <option value="3">3 пассажира</option>
                                    <option value="4">4 пассажира</option>
                                    <option value="5">5 пассажиров</option>
                                    <option value="6">6 пассажиров</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 rounded-lg text-lg transition shadow-lg">
                                    Найти билеты
                                </button>
                            </div>
                        </div>

                        <div id="passengers-details" class="hidden border-t border-gray-200 pt-6 mt-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Детали пассажиров</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="text-sm font-semibold text-gray-600 block mb-2">Взрослый</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" class="dec-adult w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                                        <input type="number" name="adult_person" id="adult_person" value="0" min="0" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" class="inc-adult w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-600 block mb-2">Ребёнок с местом</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" class="dec-child-place w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                                        <input type="number" name="child_with_place" id="child_with_place" value="0" min="0" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" class="inc-child-place w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-600 block mb-2">Ребёнок без места (0-5 лет)</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" class="dec-child-no-place w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                                        <input type="number" name="child_without_place" id="child_without_place" value="0" min="0" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" class="inc-child-no-place w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 mb-4">Специальные места</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="text-sm font-semibold text-gray-600 block mb-2">Для инвалида</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" class="dec-invalid w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                                        <input type="number" name="place_for_invalid" id="place_for_invalid" value="0" min="0" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" class="inc-invalid w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-600 block mb-2">Для многодетных семей</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" class="dec-family w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                                        <input type="number" name="place_for_family" id="place_for_family" value="0" min="0" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                        <button type="button" class="inc-family w-8 h-8 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 mb-4">Багаж</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="pets" value="1" class="w-5 h-5 text-red-600 rounded">
                                    <span class="text-gray-700">Животное без пассажира</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="car" value="1" class="w-5 h-5 text-red-600 rounded">
                                    <span class="text-gray-700">Автомобиль в автовозе</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="motorcycle" value="1" class="w-5 h-5 text-red-600 rounded">
                                    <span class="text-gray-700">Мотоцикл в автовозе</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    document.getElementById('swap-stations')?.addEventListener('click', function() {
                        const from = document.getElementById('from_station');
                        const to = document.getElementById('to_station');
                        const fromVal = from.value;
                        const toVal = to.value;
                        from.value = toVal;
                        to.value = fromVal;
                    });

                    const dropdown = document.getElementById('passengers-dropdown');
                    const detailsBlock = document.getElementById('passengers-details');

                    dropdown?.addEventListener('change', function() {
                        if (this.value > 0) {
                            detailsBlock.classList.remove('hidden');
                        } else {
                            detailsBlock.classList.add('hidden');
                        }
                    });

                    function setupCounter(decrementBtn, incrementBtn, input, max = 99) {
                        decrementBtn?.addEventListener('click', () => {
                            let val = parseInt(input.value) || 0;
                            if (val > 0) input.value = val - 1;
                        });
                        incrementBtn?.addEventListener('click', () => {
                            let val = parseInt(input.value) || 0;
                            if (val < max) input.value = val + 1;
                        });
                        input?.addEventListener('change', () => {
                            let val = parseInt(input.value) || 0;
                            if (val < 0) input.value = 0;
                            if (val > max) input.value = max;
                        });
                    }

                    setupCounter(
                        document.querySelector('.dec-adult'),
                        document.querySelector('.inc-adult'),
                        document.getElementById('adult_person')
                    );
                    setupCounter(
                        document.querySelector('.dec-child-place'),
                        document.querySelector('.inc-child-place'),
                        document.getElementById('child_with_place')
                    );
                    setupCounter(
                        document.querySelector('.dec-child-no-place'),
                        document.querySelector('.inc-child-no-place'),
                        document.getElementById('child_without_place')
                    );
                    setupCounter(
                        document.querySelector('.dec-invalid'),
                        document.querySelector('.inc-invalid'),
                        document.getElementById('place_for_invalid')
                    );
                    setupCounter(
                        document.querySelector('.dec-family'),
                        document.querySelector('.inc-family'),
                        document.getElementById('place_for_family')
                    );
                </script>
            @endauth

            @guest
                <div class="text-center py-16">
                    <h2 class="text-3xl font-semibold text-gray-700">Авторизуйтесь, чтобы начать поиск билетов</h2>
                </div>
            @endguest
        </div>
    </section>

    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16">Почему выбирают нас</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="font-semibold text-xl mb-3">Быстро</h3>
                    <p class="text-gray-600">Мгновенный поиск и бронирование билетов без очередей.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="font-semibold text-xl mb-3">Безопасно</h3>
                    <p class="text-gray-600">Надёжные способы оплаты и защита данных.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🌍</div>
                    <h3 class="font-semibold text-xl mb-3">По всей стране</h3>
                    <p class="text-gray-600">Доступ к тысячам маршрутов и направлений.</p>
                </div>
            </div>
        </div>
    </section>

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
