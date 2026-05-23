@extends('layout.index')
@section('title', 'Главная')
@section('content')

    <div class="flex justify-center mt-24 px-4">
        @auth
        <form action="{{ route('trains.search') }}" method="GET" class="w-full max-w-6xl">
            <div class="bg-white rounded-xl shadow-lg p-8 grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Колонка 1: Станции -->
                <div class="flex flex-col gap-4">
                    <label class="text-sm font-medium text-gray-700">Станции</label>
                    <div class="flex items-center gap-3">
                        <select id="fromStation" name="from_station" class="w-[calc(50%-1.75rem)] border rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 text-lg">
                            <option value="">Откуда</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>

                        <button id="swapStations" type="button" class="w-14 h-14 flex items-center justify-center border border-gray-300 rounded-full text-2xl hover:bg-gray-100 transition">⇄</button>

                        <select id="toStation" name="to_station" class="w-[calc(50%-1.75rem)] border rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-600 text-lg">
                            <option value="">Куда</option>
                            @foreach($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Колонка 2: Даты -->
                <div class="flex flex-col gap-4">
                    <label class="text-sm font-medium text-gray-700">Даты</label>
                    <input id="dateFrom" name="date_from" placeholder="Туда" class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-red-600">
                    <input id="dateTo" name="date_to" placeholder="Обратно" class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-red-600">
                </div>

                <!-- Колонка 3: Пассажиры и багаж -->
                <div class="flex flex-col gap-4 relative">
                    <label class="text-sm font-medium text-gray-700">Пассажиры и багаж</label>
                    <div class="relative">
                        <button id="passengersBtn" type="button" class="flex items-center gap-2 border border-gray-300 rounded-lg px-4 py-3 hover:bg-gray-100 w-full">
                            👤 <span id="passengersLabel">1 пассажир</span>
                        </button>
                        <div id="passengersDropdown" class="hidden absolute top-full right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 z-50 p-4 space-y-4">
                            <h4 class="font-semibold text-gray-700 mb-2">Пассажиры</h4>
                            @foreach (['Взрослый','Ребёнок с местом','Ребёнок без места'] as $label)
                                <div class="flex justify-between items-center">
                                    <span>{{ $label }}</span>
                                    <div class="flex items-center gap-2">
                                        <button class="counter-btn px-3 py-1 border rounded" type="button">−</button>
                                        <span class="w-6 text-center">0</span>
                                        <button class="counter-btn px-3 py-1 border rounded" type="button">+</button>
                                    </div>
                                </div>
                            @endforeach
                            <h4 class="font-semibold text-gray-700 mb-2">Багаж</h4>
                            @foreach (['Животное','Автомобиль','Мотоцикл'] as $label)
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-sm">{{ $label }}</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-red-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-10 py-3 rounded-lg text-lg mt-auto w-full">
                        НАЙТИ
                    </button>
                </div>

            </div>
        </form>
        @endauth
    </div>
    @guest
        <div class="fixed inset-0 flex items-center justify-center pointer-events-none z-0">
            <h1 class="text-4xl font-semibold text-gray-700 text-center">
                Авторизуйтесь, прежде чем продолжить
            </h1>
        </div>
    @endguest
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('click', e => {
            const btn = document.getElementById('passengersBtn');
            const dropdown = document.getElementById('passengersDropdown');

            if (!btn || !dropdown) return;

            if (btn.contains(e.target)) {
                dropdown.classList.toggle('hidden');
            } else if (!dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // swap stations
        document.getElementById('swapStations')?.addEventListener('click', () => {
            const from = document.getElementById('fromStation');
            const to = document.getElementById('toStation');

            if (!from || !to) return;

            const temp = from.value;
            from.value = to.value;
            to.value = temp;
        });

        // counters
        const counters = document.querySelectorAll('.counter-btn');
        const passengersLabel = document.getElementById('passengersLabel');

        counters.forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();

                const span = btn.parentElement.querySelector('span');
                let value = parseInt(span.textContent);

                if (btn.textContent === '+') value++;
                if (btn.textContent === '−') value = Math.max(0, value - 1);

                span.textContent = value;

                let total = 0;
                document.querySelectorAll('#passengersDropdown span.w-6')
                    .forEach(s => total += parseInt(s.textContent));

                passengersLabel.textContent = total + (total === 1 ? ' пассажир' : ' пассажиров');
            });
        });

        // flatpickr
        const dateFrom = flatpickr("#dateFrom", {
            dateFormat: "d.m.Y",
            minDate: "today",
            locale: "ru",
            onChange: function(selectedDates) {
                if (selectedDates.length > 0) {
                    dateTo.set('minDate', selectedDates[0]);
                } else {
                    dateTo.set('minDate', "today");
                }
            }
        });

        const dateTo = flatpickr("#dateTo", {
            dateFormat: "d.m.Y",
            minDate: "today",
            locale: "ru"
        });
    </script>

@endsection
