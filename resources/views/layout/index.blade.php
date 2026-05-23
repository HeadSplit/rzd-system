<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield('title', 'РЖД')</title>
</head>
<body class="bg-gray-100">

<header class="bg-black text-white h-14 flex items-center justify-between px-3 sm:px-6">
    {{-- Логотип РЖД --}}
    <div class="flex items-center">
        <svg class="h-7 w-10 sm:h-8 sm:w-12" viewBox="0 0 60 30" fill="none">
            <text x="0" y="24" fill="white" font-size="22" font-weight="bold"><a href="{{route('home')}}">РЖД</a></text>
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
       @guest() <span class="text-xs sm:text-sm font-medium">
    <button id="loginButtonDesktop" type="button">Войти</button>
</span>@endguest
        <span class="hidden sm:inline text-gray-500">|</span>
        <button class="text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div id="mobileMenu" class="md:hidden hidden mt-2 space-y-2 relative z-10">
            <a href="#" class="block text-gray-800 font-medium hover:text-red-600">Билеты</a>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.tickets') }}" class="block text-gray-800 font-medium hover:text-red-600">Админка</a>
                @endif
            @endauth
            @guest
                <button id="loginButtonMobile" type="button" class="select-none cursor-pointer block w-full px-4 py-2 text-left text-red-600 border border-red-600 rounded hover:bg-red-600 hover:text-white transition">
                    Войти
                </button>
            @endguest
        </div>
    </div>
</header>
<main class="max-w-7xl mx-auto px-4 py-6">
    @yield('content')
</main>

<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden pointer-events-none flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md pointer-events-auto">
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
                    <input type="text" name="login" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600" required autofocus>
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
    document.addEventListener('DOMContentLoaded', () => {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const loginButtonDesktop = document.getElementById('loginButtonDesktop');
        const loginButtonMobile = document.getElementById('loginButtonMobile');
        const loginModal = document.getElementById('loginModal');
        const cancelLogin = document.getElementById('cancelLogin');

        mobileMenuButton?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const openLoginModal = () => {
            loginModal.classList.remove('hidden');
            loginModal.classList.add('pointer-events-auto');
        };

        loginButtonDesktop?.addEventListener('click', openLoginModal);
        loginButtonMobile?.addEventListener('click', openLoginModal);
        cancelLogin?.addEventListener('click', () => {
            loginModal.classList.add('hidden');
            loginModal.classList.remove('pointer-events-auto');
        });

        @if ($errors->has('auth'))
        openLoginModal();
        @endif
    });
</script>

</body>
</html>
