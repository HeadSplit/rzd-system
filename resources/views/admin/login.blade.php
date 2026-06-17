@extends('layout.admin')

@section('title', 'Вход администратора')

@section('page-title', 'Авторизация')
@section('page-description', 'Введите логин и пароль администратора')

@section('content')

    <div class="max-w-md mx-auto">

        <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-8 shadow-xl">

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <input
                        type="text"
                        name="login"
                        required
                        autofocus
                        class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 focus:border-red-600 focus:outline-none transition"
                        placeholder="Логин"
                    >
                </div>

                <div>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 focus:border-red-600 focus:outline-none transition"
                        placeholder="Пароль"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 transition font-semibold"
                >
                    Войти
                </button>

            </form>
            <a href="{{route('home')}}">Назад</a>
        </div>
    </div>
@endsection
