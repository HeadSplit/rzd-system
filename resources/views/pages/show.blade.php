{{-- resources/views/booking/passengers.blade.php --}}

    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Укажите данные пассажиров</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- Верхний хедер --}}
<header class="bg-black text-white h-14 flex items-center justify-between px-3 sm:px-6">
    {{-- Логотип РЖД --}}
    <div class="flex items-center">
        <svg class="h-7 w-10 sm:h-8 sm:w-12" viewBox="0 0 60 30" fill="none">
            <text x="0" y="24" fill="white" font-size="22" font-weight="bold">РЖД</text>
        </svg>
    </div>
    {{-- Правая часть хедера --}}
    <div class="flex items-center space-x-3 sm:space-x-6">
        {{-- Иконка очков - скрыта на мобилке --}}
        <button class="hidden sm:block text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="7" cy="12" r="3"/>
                <circle cx="17" cy="12" r="3"/>
                <path d="M10 12h4"/>
                <path d="M4 12H1"/>
                <path d="M23 12h-3"/>
            </svg>
        </button>
        <button class="text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        </button>
        <span class="hidden sm:inline text-gray-500">|</span>
        <span class="text-xs sm:text-sm font-medium">RU</span>
        <span class="hidden sm:inline text-gray-500">|</span>
        <button class="text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</header>

{{-- Основной контент --}}
<main class="flex-1 max-w-5xl mx-auto w-full px-3 sm:px-4 py-4 sm:py-8">

    {{-- Блок шагов и заголовка --}}
    <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6">
        {{-- Шаги --}}
        <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
            <a href="#" {{-- route('booking.previous') --}} class="text-gray-700 hover:text-black mr-1 sm:mr-2 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>

            {{-- Шаги (1-7) --}}
            <div class="flex items-center gap-1 sm:gap-2 overflow-x-auto">
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gray-500 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">1</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-gray-500 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">2</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-black text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">3</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border border-gray-300 text-gray-500 flex items-center justify-center text-xs font-semibold flex-shrink-0">4</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border border-gray-300 text-gray-500 flex items-center justify-center text-xs font-semibold flex-shrink-0">5</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border border-gray-300 text-gray-500 flex items-center justify-center text-xs font-semibold flex-shrink-0">6</div>
                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border border-gray-300 text-gray-500 flex items-center justify-center text-xs font-semibold flex-shrink-0">7</div>
            </div>
        </div>

        {{-- Заголовок --}}
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-4 sm:mb-6 sm:pl-10">
            Укажите данные пассажиров
        </h1>

        {{-- Информация о поезде --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 sm:pl-10">
            {{-- Логотип поезда (заглушка) --}}
            <div class="flex-shrink-0 w-20 h-12 flex items-center justify-center">
                <div class="text-amber-700 text-center">
                    <div class="text-[10px] tracking-wider">НОЧНОЙ</div>
                    <div class="text-[10px] tracking-wider">ЭКСПРЕСС</div>
                </div>
            </div>
            <p class="text-sm sm:text-base text-gray-900">
                <span class="font-bold">022 «Ночной экспресс»</span>
                Москва Октябрьская — Санкт-Петербург-Главный, отпр. 00:25, 11 июня, чт
            </p>
        </div>
    </div>

    {{-- Карточка пассажира --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">

        {{-- Верхняя часть с данными пассажира --}}
        <div class="p-4 sm:p-6 lg:p-8">
            {{-- Заголовок пассажира и цена --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-4 sm:mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Пассажир 1</h2>
                <div class="text-xl sm:text-2xl font-bold text-gray-900">
                    8 541<span class="text-sm sm:text-base font-normal">,00 ₽</span>
                </div>
            </div>

            {{-- Информация о месте --}}
            <div class="mb-4 sm:mb-6 space-y-1">
                <p class="text-sm sm:text-base text-gray-900">Вагон 02 Купе 8 Место 30</p>
                <p class="text-sm sm:text-base text-gray-900">Купе 2Ф, ТВЕРСК, Верхнее</p>
            </div>

            {{-- Кнопка "Ввести данные" и описание --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-start gap-4 sm:gap-6">
                <form action="#" {{-- route('passenger.create') --}} method="GET" class="flex-shrink-0">
                    <button type="submit"
                            class="w-full sm:w-auto border border-gray-400 hover:border-black text-gray-900 font-semibold px-6 sm:px-10 py-3 sm:py-4 rounded-md transition-colors tracking-wide text-xs sm:text-sm">
                        ВВЕСТИ ДАННЫЕ
                    </button>
                </form>
                <p class="text-xs sm:text-sm text-gray-600 sm:pt-1">
                    Для приобретения билета необходимо ввести данные о пассажире, которые будут храниться в личном кабинете
                </p>
            </div>
        </div>

        {{-- Разделитель --}}
        <hr class="border-gray-200">

        {{-- Нижняя часть с сообщением и кнопкой --}}
        <div class="p-4 sm:p-6 lg:p-8">
            <p class="text-sm sm:text-base text-gray-900 mb-4 sm:mb-6">
                Поездка Москва Октябрьская — Санкт-Петербург-Главный, поезд 022, Выберите класс обслуживания и место добавлена в корзину.
            </p>

            <div class="flex justify-center">
                <form action="#" {{-- route('booking.return') --}} method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                            class="w-full sm:w-auto bg-black hover:bg-gray-800 text-white font-semibold px-8 sm:px-12 py-3 sm:py-4 rounded-md transition-colors tracking-wide text-xs sm:text-sm">
                        К ОБРАТНОЙ ПОЕЗДКЕ
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

{{-- Футер --}}
<footer class="border-t border-gray-200 bg-white mt-6 sm:mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm text-gray-700">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-8">
            {{-- Выбор языка --}}
            <button class="flex items-center gap-1 hover:text-black self-start">
                <span>Russian (Ru)</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            {{-- Ссылки --}}
            <a href="#" {{-- route('support') --}} class="underline hover:text-black">
                Техническая поддержка
            </a>
            <a href="#" {{-- route('rating') --}} class="underline hover:text-black">
                Оценить работу портала
            </a>
        </div>
        <div class="text-gray-700">
            2003—2026 ОАО «РЖД»
        </div>
    </div>
</footer>

</body>
</html>
