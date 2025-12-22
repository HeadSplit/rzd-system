@extends('layout.index')
@section('title', 'Выбор места')

@section('content')
    @php
        use App\Enums\SeatTypeEnum;

        $seats = $seats
            ->where('is_available', true)
            ->sortBy('number')
            ->values();

        $totalSeats = $seats->count();
        $isDouble = $totalSeats > 50;

        $floors = $isDouble ? 2 : 1;
        $perSide = 4;
        $perRow = $perSide * 2;

        $fullRowsPerFloor = floor($totalSeats / $floors / $perRow);
        $remainingSeatsPerFloor = ceil(($totalSeats / $floors) - ($fullRowsPerFloor * $perRow));

        $layout = [];
        $seatIndex = 0;

        for ($floor = 1; $floor <= $floors; $floor++) {
            $floorRows = [];

            for ($row = 1; $row <= $fullRowsPerFloor; $row++) {
                $rowSeats = [];

                for ($i = 0; $i < $perRow && $seatIndex < $totalSeats; $i++) {
                    $rowSeats[] = $seats[$seatIndex];
                    $seatIndex++;
                }

                $floorRows[] = [
                    'is_full' => true,
                    'left' => array_slice($rowSeats, 0, $perSide),
                    'right' => array_slice($rowSeats, $perSide, $perSide),
                ];
            }

            if ($remainingSeatsPerFloor > 0 && $seatIndex < $totalSeats) {
                $rowSeats = [];
                $seatsInThisRow = min($remainingSeatsPerFloor, $perRow);

                for ($i = 0; $i < $seatsInThisRow && $seatIndex < $totalSeats; $i++) {
                    $rowSeats[] = $seats[$seatIndex];
                    $seatIndex++;
                }

                if ($seatsInThisRow <= $perSide) {
                    $floorRows[] = [
                        'is_full' => false,
                        'left' => $rowSeats,
                        'right' => [],
                    ];
                } else {
                    $floorRows[] = [
                        'is_full' => false,
                        'left' => array_slice($rowSeats, 0, $perSide),
                        'right' => array_slice($rowSeats, $perSide),
                    ];
                }
            }

            if (!empty($floorRows)) {
                $layout[$floor] = $floorRows;
            }
        }
    @endphp

    <form
        id="seatSelectionForm"
        method="GET"
        action="{{ route('routes.passenger', ['route' => $route->id, 'wagon' => $wagon->id]) }}"
        class="max-w-6xl mx-auto pb-32"
    >
        <input type="hidden" name="selected_seats" id="selectedSeatsInput">

        <h2 class="text-xl mb-6">
            Доступно мест: <span class="text-red-600">{{ $totalSeats }}</span>
        </h2>

        @foreach($layout as $floor => $rows)
            <div class="border rounded-xl p-6 mb-10 bg-white">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <div class="text-lg">Вагон {{ $wagon->number }}</div>
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
                            <div class="flex gap-2">
                                @foreach($row['left'] as $seat)
                                    @php
                                        $size = match ($seat->type) {
                                            SeatTypeEnum::meetingRoom => 'w-16 h-16',
                                            SeatTypeEnum::suite, SeatTypeEnum::premium => 'w-12 h-12',
                                            default => 'w-10 h-10',
                                        };
                                    @endphp
                                    <div
                                        class="seat-item flex items-center justify-center rounded-md text-sm bg-blue-200 hover:bg-blue-300 cursor-pointer {{ $size }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-seat-number="{{ $seat->number }}"
                                        data-seat-price="{{ $seat->price }}"
                                    >
                                        {{ $seat->number }}
                                    </div>
                                @endforeach

                                @for($i = count($row['left']); $i < $perSide; $i++)
                                    <div class="w-10 h-10"></div>
                                @endfor
                            </div>

                            <div class="w-8"></div>

                            <div class="flex gap-2">
                                @foreach($row['right'] as $seat)
                                    @php
                                        $size = match ($seat->type) {
                                            SeatTypeEnum::meetingRoom => 'w-16 h-16',
                                            SeatTypeEnum::suite, SeatTypeEnum::premium => 'w-12 h-12',
                                            default => 'w-10 h-10',
                                        };
                                    @endphp
                                    <div
                                        class="seat-item flex items-center justify-center rounded-md text-sm bg-blue-200 hover:bg-blue-300 cursor-pointer {{ $size }}"
                                        data-seat-id="{{ $seat->id }}"
                                        data-seat-number="{{ $seat->number }}"
                                        data-seat-price="{{ $seat->price }}"
                                    >
                                        {{ $seat->number }}
                                    </div>
                                @endforeach

                                @for($i = count($row['right']); $i < $perSide; $i++)
                                    <div class="w-10 h-10"></div>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div id="priceBar" class="fixed bottom-0 left-0 right-0 bg-white border-t px-6 py-4 hidden">
            <div class="max-w-6xl mx-auto flex justify-between items-center">
                <div class="text-lg">
                    Выбрано <span id="selectedCount" class="text-red-600">0</span> мест
                    на сумму <span id="totalPrice" class="text-red-600">0</span> ₽
                    <div id="selectedNumbers" class="text-sm text-gray-600 mt-1"></div>
                </div>

                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg">
                    Продолжить
                </button>
            </div>
        </div>
    </form>

    <script>
        let selectedSeats = new Set()
        let totalPrice = 0

        document.querySelectorAll('.seat-item').forEach(seat => {
            seat.addEventListener('click', () => {
                const id = seat.dataset.seatId
                const price = parseInt(seat.dataset.seatPrice) || 0

                if (selectedSeats.has(id)) {
                    selectedSeats.delete(id)
                    totalPrice -= price
                    seat.classList.remove('bg-red-600', 'text-white')
                    seat.classList.add('bg-blue-200')
                } else {
                    selectedSeats.add(id)
                    totalPrice += price
                    seat.classList.remove('bg-blue-200')
                    seat.classList.add('bg-red-600', 'text-white')
                }

                update()
            })
        })

        function update() {
            const bar = document.getElementById('priceBar')

            if (selectedSeats.size === 0) {
                bar.classList.add('hidden')
                document.getElementById('selectedSeatsInput').value = ''
                return
            }

            bar.classList.remove('hidden')
            document.getElementById('selectedCount').textContent = selectedSeats.size
            document.getElementById('totalPrice').textContent = totalPrice.toLocaleString('ru-RU')

            const numbers = Array.from(document.querySelectorAll('.seat-item.bg-red-600'))
                .map(el => el.dataset.seatNumber)
                .join(', ')

            document.getElementById('selectedNumbers').textContent = 'Места: ' + numbers
            document.getElementById('selectedSeatsInput').value = Array.from(selectedSeats).join(',')
        }
    </script>
@endsection
