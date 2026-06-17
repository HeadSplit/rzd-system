<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Панель управления смертными')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white">

<div class="min-h-screen">

    {{-- HEADER --}}
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-black/50 border-b border-red-900/30">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <div class="overflow-hidden border-b border-red-950 bg-red-950/30">
            <div class="whitespace-nowrap py-1 animate-marquee text-red-400 font-semibold tracking-widest">
                Милосердие — удел слабых • Милосердие — удел слабых • Милосердие — удел слабых • Милосердие — удел слабых
            </div>
        </div>

        <div class="h-16 px-8 flex items-center justify-between">

            <div class="flex items-center gap-4">

                <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center font-bold">
                    A
                </div>

                <div>
                    <h1 class="font-bold text-lg">
                        Панель управления администратора
                    </h1>

                </div>

            </div>
            @auth
            <div class="flex items-center gap-4">

                <span class="text-sm text-slate-300">
                    {{ auth()->user()->name }}
                </span>

                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-red-500 to-red-700 flex items-center justify-center font-bold">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>

            </div>
            @endauth
        </div>

    </header>

    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="w-72 min-h-[calc(100vh-65px)] border-r border-slate-800 bg-black/20 backdrop-blur-xl">

            <div class="p-6">

                <nav class="space-y-2">
                    @can('admin')
                    <a href="{{ route('admin.tickets') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                        🚆
                        Билеты
                    </a>

                    <a href="{{ route('admin.users') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                        👤
                        Пользователи
                    </a>

                    <a href="{{ route('admin.passangers') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                        🎫
                        Пассажиры
                    </a>

                        <a href="{{ route('admin.groups') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                            Группы
                        </a>

                    <a href="{{ route('admin.results') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                        📊
                        Аналитика
                    </a>

                        <a href="{{ route('home') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-900 transition">
                           Выход
                        </a>
                    @endcan
                </nav>

            </div>

            <div class="absolute bottom-6 left-6 right-6">

                <form method="get" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full px-4 py-3 rounded-xl bg-red-600 hover:bg-red-700 transition"
                    >
                        Выйти
                    </button>
                </form>

            </div>

        </aside>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-8">

            {{-- Заголовок страницы --}}
            <div class="mb-8">
                <h2 class="text-3xl font-bold">
                    @yield('page-title')
                </h2>

                <p class="text-slate-400 mt-1">
                    @yield('page-description')
                </p>
            </div>

            {{-- Контент страницы --}}
            @yield('content')

        </main>

    </div>

</div>

</body>
</html>
