@extends('layout.index')
@section('title', 'Выбор класса')

@section('content')
    <div class="max-w-5xl mx-auto py-6">
        <div class="bg-gray-100 border-l-4 border-red-500 p-4 mb-6">
            <h1 class="text-xl font-semibold">Выберите класс обслуживания</h1>
        </div>

        <h2 class="text-2xl font-bold mb-4">Поезд {{ $route->name }}</h2>

        <form action="{{ route('routes.seats', ['route' => $route->id, 'wagon' => '__WAGON__']) }}" method="GET" id="wagonForm" class="space-y-4">
            @foreach($route->train->wagons as $wagon)
                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition duration-200">
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center space-x-2">
                            <input type="radio" name="wagon_id" value="{{ $wagon->id }}" class="form-radio h-5 w-5 text-red-500" required>
                            <span class="font-semibold text-lg">{{ $wagon->service_class->label() }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold">
                                {{ rand($wagon->wagonprice?->min_price, $wagon->wagonprice?->max_price) ?? 'не указана' }} ₽
                            </div>
                            <div class="text-sm text-gray-500 available-seats" data-count="{{ $wagon->available_seats_count }}">
                            </div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-700 mt-2">
                        {{ $wagon->description }}
                    </div>
                </div>
            @endforeach

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                    Выбрать
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function declOfNum(number, titles) {
                let cases = [2, 0, 1, 1, 1, 2];
                return titles[(number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5]];
            }

            document.querySelectorAll('.available-seats').forEach(el => {
                const count = parseInt(el.dataset.count);
                el.textContent = `${count} ${declOfNum(count, ['место', 'места', 'мест'])}`;
            });

            const form = document.getElementById('wagonForm');
            form.addEventListener('submit', function(e) {
                const selectedWagon = document.querySelector('input[name="wagon_id"]:checked');
                if (selectedWagon) {
                    form.action = "{{ route('routes.seats', ['route' => $route->id, 'wagon' => '__WAGON__']) }}".replace('__WAGON__', selectedWagon.value);
                }
            });
        });
    </script>
@endsection
