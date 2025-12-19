<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Главная')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<header class="bg-white border-b shadow">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Логотип -->
            <a href="{{ url('/') }}" class="flex-shrink-0">
                <img class="h-8" src="https://logo-teka.com/wp-content/uploads/2025/07/rzd-logo.svg" alt="Logo">
            </a>

            <!-- Меню для больших экранов -->
            <div class="hidden md:flex md:space-x-8 items-center">
                <a href="#" class="text-gray-800 font-medium hover:text-red-600">Билеты</a>

                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.tickets') }}" class="text-gray-800 font-medium hover:text-red-600">Админка</a>
                    @endif
                @endauth
            </div>

            <!-- Авторизация -->
            <div class="flex items-center space-x-4">
                @guest
                    <button id="loginButton" class="px-4 py-2 border border-red-600 text-red-600 rounded hover:bg-red-600 hover:text-white transition">
                        Войти
                    </button>
                @else
                    <span class="text-gray-700 text-sm">{{ auth()->user()->name }}</span>
                @endguest

                <!-- Бургер-меню для мобильных -->
                <div class="md:hidden">
                    <button id="mobileMenuButton" class="text-gray-800 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Мобильное меню -->
        <div id="mobileMenu" class="md:hidden hidden mt-2 space-y-2">
            <a href="#" class="block text-gray-800 font-medium hover:text-red-600">Билеты</a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.tickets') }}" class="block text-gray-800 font-medium hover:text-red-600">Админка</a>
                @endif
            @endauth
        </div>
    </nav>
</header>

<main class="max-w-7xl mx-auto px-4 py-6">
    @yield('content')
</main>

<!-- Модальное окно входа -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Вход</h2>
            </div>

            @if ($errors->has('auth'))
                <div class="px-6 py-2 text-red-600 text-sm">
                    {{ $errors->first('auth') }}
                </div>
            @endif

            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600" required autofocus>
                </div>
                <div>
                    <label class="block text-gray-700">Пароль</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600" required>
                </div>
            </div>

            <div class="px-6 py-4 border-t flex justify-end space-x-2">
                <button type="button" id="cancelLogin" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Отмена</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Войти</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Бургер-меню
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Модальное окно входа
    const loginButton = document.getElementById('loginButton');
    const loginModal = document.getElementById('loginModal');
    const cancelLogin = document.getElementById('cancelLogin');

    loginButton?.addEventListener('click', () => loginModal.classList.remove('hidden'));
    cancelLogin?.addEventListener('click', () => loginModal.classList.add('hidden'));

    @if ($errors->has('auth'))
    window.addEventListener('DOMContentLoaded', () => {
        loginModal.classList.remove('hidden');
    });
    @endif
</script>

</body>
</html>
