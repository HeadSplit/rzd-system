@extends('layout.index')
@section('content')

    <div class="flex justify-center mt-24 px-4">
        <div class="w-full max-w-6xl bg-white rounded-xl shadow-lg p-8">

            <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm border p-6 grid grid-cols-12 gap-6">
                <div class="col-span-8">
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                        <div class="flex items-center gap-2 font-medium text-gray-900">
                            <img src="/icons/train.svg" class="w-5 h-5" />
                            <span>130</span>
                        </div>
                        <span>• ФПК • Москва Казанская → Казань Пасс</span>
                        <span class="text-red-500 font-medium">Маршрут</span>
                    </div>


                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-semibold">00:20</div>
                            <div class="text-sm text-gray-500 mt-1">Москва Казанская</div>
                        </div>


                        <div class="flex-1">
                            <div class="flex items-center">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <div class="flex-1 h-px bg-red-500 mx-2"></div>
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </div>
                            <div class="text-center text-sm text-gray-500 mt-2">13 ч 7 мин</div>
                        </div>


                        <div class="text-center">
                            <div class="text-4xl font-semibold">13:27</div>
                            <div class="text-sm text-gray-500 mt-1">Казань Пасс</div>
                        </div>
                    </div>


                    <div class="flex items-center gap-6 mt-6 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a4 4 0 004 4h10" /></svg>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16" /></svg>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                        <div class="relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3z" /></svg>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">8</span>
                        </div>
                    </div>
                </div>


                <div class="col-span-4 border-l pl-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span>Плацкартный</span>
                            <span class="text-gray-500">66</span>
                            <span class="text-red-600 font-semibold">от 2 362 ₽</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Купе</span>
                            <span class="text-gray-500">24</span>
                            <span class="text-red-600 font-semibold">от 3 599 ₽</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>СВ</span>
                            <span class="text-gray-500">21</span>
                            <span class="text-red-600 font-semibold">от 8 228 ₽</span>
                        </div>
                    </div>


                    <div class="flex items-center gap-3 mt-6">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-full border text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /></svg>
                            Лист ожидания
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-full bg-red-500 text-white text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3z" /></svg>
                            Купить
                        </button>
                    </div>
                </div>
            </div>

        </div>я
    </div>

@endsection
