@extends('layout.index')
@section('title', 'Оформление билета')

@section('content')
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-5 border-b border-gray-200">
            <div class="flex flex-wrap justify-between items-start gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-rose-600 text-3xl">🚂</span>
                        Укажите данные пассажиров
                    </h1>
                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-gray-600 text-sm">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            <span>{{ $train->number }} «{{ $train->name }}»</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $route->fromStation->name }} → {{ $route->toStation->name }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>отпр. {{ $route->departure_at->format('H:i, d F, l') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-rose-50 text-rose-700 px-4 py-1.5 rounded-full text-sm font-semibold shadow-inner">
                    🎫 Поезд №{{ $train->number }}
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="border-2 border-gray-100 rounded-xl bg-gray-50/40 p-5 hover:shadow-sm transition">
                <div class="flex flex-wrap justify-between items-start gap-4 border-b border-gray-200 pb-4 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xl">1</div>
                        <h2 class="text-xl font-bold text-gray-800">Пассажир 1</h2>
                    </div>
                    <div class="bg-white rounded-lg px-4 py-2 shadow-sm border border-gray-200 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm">
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">Вагон {{ $wagon->number }}</span>
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">Купе {{ $seat->compartment }}</span>
                        <span class="font-mono bg-gray-100 px-2 py-1 rounded">Место {{ $seat->number }}</span>
                        <span class="text-rose-700 font-medium ml-1">{{ $wagon->type->name }}</span>
                    </div>
                </div>

                <div class="mb-6 flex flex-wrap items-center justify-between gap-3 bg-white p-3 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $wagon->service_class }}</span>
                        <span class="text-gray-700 text-sm">{{ $seat->place_type }}</span>
                        <span class="text-gray-400 text-xs hidden sm:inline">• {{ $wagon->type->description }}</span>
                    </div>
                    <div class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        ⚡ {{ $wagon->comfort_level }}
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <h3 class="font-semibold text-gray-800 text-lg">Введите данные пассажира</h3>
                        <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">обязательно</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-5 -mt-1">Для приобретения билета необходимо ввести данные о пассажире, которые будут храниться в личном кабинете</p>

                    <form method="POST" action="{{ ('tickets.store') }}" id="passengerForm">
                        @csrf
                        <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                        <input type="hidden" name="route_id" value="{{ $route->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Фамилия <span class="text-rose-600">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Имя <span class="text-rose-600">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Отчество (при наличии)</label>
                                <input type="text" name="patronymic" value="{{ old('patronymic') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Тип документа <span class="text-rose-600">*</span></label>
                                <select name="document_type" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white focus:border-rose-500">
                                    <option value="passport">Паспорт РФ</option>
                                    <option value="foreign">Загранпаспорт</option>
                                    <option value="birth">Свидетельство о рождении</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Серия и номер документа <span class="text-rose-600">*</span></label>
                                <input type="text" name="document_number" value="{{ old('document_number') }}" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:border-rose-500">
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap items-center gap-6 text-sm text-gray-600">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="citizenship" value="rf" checked class="w-4 h-4 text-rose-600"> Гражданин РФ
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="citizenship" value="foreign" class="w-4 h-4 text-rose-600"> Иностранный гражданин
                            </label>
                        </div>
                <div>
            </div>

            <div class="mt-8 rounded-xl bg-white border border-gray-200 p-5 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 p-2 rounded-full">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Постельное бельё</p>
                        <p class="text-sm text-gray-500">Комплект: простыня, наволочка, пододеяльник</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="text-right">
                        <span class="text-2xl font-bold text-gray-900">{{ number_format($linenPrice, 2) }} ₽</span>
                        <span class="text-xs text-gray-500 block">за комплект</span>
                    </div>
                    <button type="button" id="linenBtn" class="bg-rose-50 hover:bg-rose-100 text-rose-700 px-5 py-2 rounded-xl font-medium text-sm transition flex items-center gap-1 border border-rose-200">
                        <span>🛏️</span> Оплатить использование постельного белья
                    </button>
                    <input type="hidden" name="linen_included" id="linenField" value="0">
                </div>
            </div>

            <div class="mt-8 pt-2 flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-gray-200 pt-6">
                <a href="{{ ('trains.index') }}" class="w-full sm:w-auto bg-white border-2 border-gray-300 text-gray-700 hover:border-rose-500 hover:text-rose-600 font-semibold py-3 px-8 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    ВЫБРАТЬ ДОПОЛНИТЕЛЬНЫЕ ПОЕЗДКИ
                </a>
                <button type="submit" form="passengerForm" class="w-full sm:w-auto bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 px-10 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M18 13l1.5 6M9 21h6M12 18v3"></path></svg>
                    ОФОРМИТЬ ЗАКАЗ
                </button>
            </div>

            </form>

            <div class="mt-6 text-center text-xs text-gray-400 bg-gray-50 p-3 rounded-lg">
                <p class="flex items-center justify-center gap-1">🔒 Нажимая «Оформить заказ», вы соглашаетесь с условиями перевозки и правилами возврата билетов. Данные будут сохранены в личном кабинете.</p>
                <p class="mt-1 text-gray-500">🚆 Поездка: {{ $route->fromStation }} — {{ $route->toStation }}, поезд {{ $train->number }} · Выберите класс обслуживания и место добавления в корзину.</p>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3">
            <div class="text-2xl">🧳</div>
            <div><span class="font-semibold">Ручная кладь</span><br><span class="text-gray-500">до 36 кг бесплатно</span></div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3">
            <div class="text-2xl">🍱</div>
            <div><span class="font-semibold">Питание в поезде</span><br><span class="text-gray-500">можно заказать онлайн</span></div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm flex items-center gap-3">
            <div class="text-2xl">🎫</div>
            <div><span class="font-semibold">Электронный билет</span><br><span class="text-gray-500">без распечатки</span></div>
        </div>
    </div>

    <script>
        document.getElementById('linenBtn')?.addEventListener('click', function() {
            const field = document.getElementById('linenField');
            if (field.value === '0') {
                field.value = '1';
                this.classList.add('bg-rose-600', 'text-white', 'border-rose-600');
                this.classList.remove('bg-rose-50', 'text-rose-700', 'border-rose-200');
                alert('Постельное бельё добавлено к заказу (+' + {{ $linenPrice }} + ' ₽)');
            } else {
                field.value = '0';
                this.classList.remove('bg-rose-600', 'text-white', 'border-rose-600');
                this.classList.add('bg-rose-50', 'text-rose-700', 'border-rose-200');
                alert('Постельное бельё убрано из заказа');
            }
        });
    </script>
@endsection
