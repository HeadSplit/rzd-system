@extends('layout.index')
@section('title', 'Выбор места')

@section('content')
    @php
        use App\Enums\SeatTypeEnum;

        $availableCount = $seats->where('is_available', true)->count();
        $totalSeats = $seats->count();
        $isDouble = $totalSeats > 50;

        $floors = $isDouble ? 2 : 1;
        $perRow = 4;
        $rowsPerFloor = ceil($totalSeats / $floors / ($perRow * 2));

        $seatIndex = 0;
        $layout = [];

        foreach (range(1, $floors) as $floor) {
            for ($r = 1; $r <= $rowsPerFloor; $r++) {
                $left = [];
                $right = [];

                for ($i = 0; $i < $perRow; $i++) {
                    $left[] = $seats[$seatIndex] ?? null;
                    $seatIndex++;
                }

                for ($i = 0; $i < $perRow; $i++) {
                    $right[] = $seats[$seatIndex] ?? null;
                    $seatIndex++;
                }

                $layout[$floor][] = [
                    'left' => $left,
                    'right' => $right,
                ];
            }
        }
    @endphp

    <form id="seatSelectionForm" method="GET" action="{{ route('routes.passenger') }}" class="max-w-6xl mx-auto pb-32">
        @csrf
        <input type="hidden" name="wagon_id" value="{{ $wagon->id }}">
        <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">

        <h2 class="text-xl font-medium mb-2">
            Выберите до
            <span class="text-red-600">{{ $availableCount }}</span>
            мест
        </h2>

        <div class="flex items-center gap-2 text-sm text-gray-600 mb-8">
            <span>Вагон {{ $wagon->number }}</span>
            <span>{{ $wagon->direction === 'left' ? '←' : '→' }}</span>
        </div>

        @foreach($layout as $floor => $rows)
            <div class="border rounded-xl p-6 mb-10 bg-white">

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <div class="text-lg font-semibold">Вагон {{ $wagon->number }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $wagon->service_class }} · {{ $wagon->type->label() }}
                        </div>
                    </div>

                    @if($floors === 2)
                        <div class="text-sm text-gray-500">
                            {{ $floor === 1 ? 'Нижний этаж' : 'Верхний этаж' }}
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach($rows as $row)
                        <div class="flex justify-center items-center gap-8">
                            <!-- Левая сторона -->
                            <div class="flex gap-2">
                                @foreach($row['left'] as $seat)
                                    @php
                                        if (!$seat) {
                                            $size = 'w-10 h-10';
                                            $state = 'bg-gray-200';
                                            $disabled = true;
                                        } else {
                                            $size = match ($seat->type) {
                                               App\Enums\SeatTypeEnum::meetingRoom => 'w-16 h-16',
                                                App\Enums\SeatTypeEnum::suite, App\Enums\SeatTypeEnum::premium => 'w-12 h-12',
                                                default => 'w-10 h-10',
                                            };

                                            $disabled = !$seat->is_available;
                                            $state = $disabled
                                                ? 'bg-gray-300 cursor-not-allowed'
                                                : 'bg-blue-200 hover:bg-blue-300 cursor-pointer';
                                        }
                                    @endphp

                                    @if($seat)
                                        <div
                                            class="seat-item flex items-center justify-center rounded-md text-sm transition {{ $size }} {{ $state }}"
                                            data-seat-id="{{ $seat->id }}"
                                            data-seat-number="{{ $seat->number }}"
                                            data-seat-price="{{ $seat->price }}"
                                            data-available="{{ $seat->is_available ? 'true' : 'false' }}"
                                        >
                                            {{ $seat->number }}
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center rounded-md text-sm {{ $size }} {{ $state }}"></div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="w-8"></div>

                            <!-- Правая сторона -->
                            <div class="flex gap-2">
                                @foreach($row['right'] as $seat)
                                    @php
                                        if (!$seat) {
                                            $size = 'w-10 h-10';
                                            $state = 'bg-gray-200';
                                            $disabled = true;
                                        } else {
                                            $size = match ($seat->type) {
                                                App\Enums\SeatTypeEnum::meetingRoom => 'w-16 h-16',
                                                App\Enums\SeatTypeEnum::suite, App\Enums\SeatTypeEnum::premium => 'w-12 h-12',
                                                default => 'w-10 h-10',
                                            };

                                            $disabled = !$seat->is_available;
                                            $state = $disabled
                                                ? 'bg-gray-300 cursor-not-allowed'
                                                : 'bg-blue-200 hover:bg-blue-300 cursor-pointer';
                                        }
                                    @endphp

                                    @if($seat)
                                        <div
                                            class="seat-item flex items-center justify-center rounded-md text-sm transition {{ $size }} {{ $state }}"
                                            data-seat-id="{{ $seat->id }}"
                                            data-seat-number="{{ $seat->number }}"
                                            data-seat-price="{{ $seat->price }}"
                                            data-available="{{ $seat->is_available ? 'true' : 'false' }}"
                                        >
                                            {{ $seat->number }}
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center rounded-md text-sm {{ $size }} {{ $state }}"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div id="priceBar" class="fixed bottom-0 left-0 right-0 bg-white border-t px-6 py-4 hidden shadow-lg">
            <div class="max-w-6xl mx-auto flex justify-between items-center">
                <div class="text-lg">
                    Выбрано <span id="selectedCount" class="text-red-600 font-semibold">0</span> мест
                    на сумму <span id="totalPrice" class="text-red-600 font-semibold">0</span> ₽
                    <div id="selectedNumbers" class="text-sm text-gray-600 mt-1"></div>
                </div>

                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-medium transition">
                    Продолжить
                </button>
            </div>
        </div>
    </form>

    <script>
        let selectedSeats = new Set();
        let totalPrice = 0;

        document.querySelectorAll('.seat-item').forEach(seat => {
            seat.addEventListener('click', () => {
                const seatId = seat.getAttribute('data-seat-id');
                const isAvailable = seat.getAttribute('data-available') === 'true';
                const seatNumber = seat.getAttribute('data-seat-number');
                const seatPrice = parseInt(seat.getAttribute('data-seat-price')) || 0;

                if (!isAvailable) return;

                if (selectedSeats.has(seatId)) {
                    // Убираем выбор
                    selectedSeats.delete(seatId);
                    totalPrice -= seatPrice;
                    seat.classList.remove('bg-red-600', 'text-white');
                    seat.classList.add('bg-blue-200');
                } else {
                    // Добавляем выбор
                    selectedSeats.add(seatId);
                    totalPrice += seatPrice;
                    seat.classList.remove('bg-blue-200');
                    seat.classList.add('bg-red-600', 'text-white');
                }

                updateSelectionDisplay();
            });
        });

        function updateSelectionDisplay() {
            const count = selectedSeats.size;
            const priceBar = document.getElementById('priceBar');
            const selectedCount = document.getElementById('selectedCount');
            const totalPriceEl = document.getElementById('totalPrice');
            const selectedNumbers = document.getElementById('selectedNumbers');
            const selectedSeatsInput = document.getElementById('selectedSeatsInput');

            if (count > 0) {
                priceBar.classList.remove('hidden');
                selectedCount.textContent = count;
                totalPriceEl.textContent = totalPrice.toLocaleString('ru-RU');

                // Получаем номера выбранных мест
                const seatNumbers = Array.from(document.querySelectorAll('.seat-item.bg-red-600'))
                    .map(seat => seat.getAttribute('data-seat-number'))
                    .join(', ');
                selectedNumbers.textContent = `Места: ${seatNumbers}`;

                // Заполняем скрытое поле для формы
                selectedSeatsInput.value = Array.from(selectedSeats).join(',');
            } else {
                priceBar.classList.add('hidden');
                selectedSeatsInput.value = '';
            }
        }

        // Обработка отправки формы
        document.getElementById('seatSelectionForm').addEventListener('submit', function(e) {
            if (selectedSeats.size === 0) {
                e.preventDefault();
                alert('Пожалуйста, выберите хотя бы одно место');
                return;
            }

            // Можно добавить дополнительную валидацию здесь
        });
    </script>

    <style>
        .seat-item {
            transition: all 0.2s ease;
            user-select: none;
        }

        .seat-item:hover:not(.bg-gray-300) {
            transform: scale(1.05);
        }

        #priceBar {
            transition: all 0.3s ease;
            z-index: 100;
        }
    </style>
@endsection
