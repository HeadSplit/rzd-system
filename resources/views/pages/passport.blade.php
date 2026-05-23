@extends('layout.index')
@section('content')
    <div class="bg-white border-b border-gray-200 px-3 sm:px-6 py-3 sm:py-4 flex items-center">
        <a href="#" {{-- route('назад') --}} class="text-gray-700 hover:text-black mr-3 sm:mr-4 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-base sm:text-lg font-medium text-center flex-1 pr-8">Данные пассажира</h1>
    </div>

    {{-- Основной контент --}}
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8 flex flex-col lg:flex-row gap-4 lg:gap-8">

        {{-- Левая колонка - боковое меню --}}
        <aside class="w-full lg:w-80 lg:flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="flex flex-col items-center pt-6 sm:pt-8 pb-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-200 rounded-full flex items-center justify-center mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">НОВЫЙ ПАССАЖИР</h2>
                </div>

                {{-- Навигация (горизонтальная на мобилке, вертикальная на десктопе) --}}
                <nav class="mt-2 flex lg:block overflow-x-auto border-t border-gray-100">
                    <a href="#" {{-- route('passenger.documents') --}}
                    class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 bg-black text-white text-sm sm:text-base font-medium border-b-4 lg:border-b-0 lg:border-l-4 border-orange-500 whitespace-nowrap">
                        Документы и контакты
                    </a>
                    <a href="#" {{-- route('passenger.bonuses') --}}
                    class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Бонусы и скидки
                    </a>
                    <a href="#" {{-- route('passenger.cards') --}}
                    class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Проездные карты
                    </a>
                    <a href="#" {{-- route('passenger.benefits') --}}
                    class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Льготный проезд
                    </a>
                </nav>
            </div>
        </aside>

        {{-- Правая колонка - формы --}}
        <main class="flex-1 min-w-0">
            <form action="#" {{-- route('passenger.store') --}} method="POST" id="passenger-form">
                @csrf

                {{-- Основная информация --}}
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Основная информация</h2>
                    <button type="button" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 mb-6 sm:mb-8">
                    {{-- ФИО --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="relative">
                            <input type="text" name="last_name" id="last_name"
                                   class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                   placeholder="Фамилия"
                                   value="{{-- $passenger->last_name --}}">
                            <label for="last_name"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Фамилия <span class="text-orange-500">*</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="text" name="first_name" id="first_name"
                                   class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                   placeholder="Имя"
                                   value="{{-- $passenger->first_name --}}">
                            <label for="first_name"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Имя <span class="text-orange-500">*</span>
                            </label>
                        </div>

                        <div>
                            <div class="relative">
                                <input type="text" name="middle_name" id="middle_name"
                                       class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                       placeholder="Отчество"
                                       value="{{-- $passenger->middle_name --}}">
                                <label for="middle_name"
                                       class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                    Отчество <span class="text-orange-500">*</span>
                                </label>
                            </div>
                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="no_middle_name" id="no_middle_name"
                                       class="w-4 h-4 border-gray-300 rounded text-orange-500 focus:ring-orange-500">
                                <label for="no_middle_name" class="ml-2 text-sm text-gray-600">
                                    Пассажир не имеет отчества
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Пол и дата рождения --}}
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Пол</label>
                            <div class="flex">
                                <label class="flex-1 sm:flex-initial flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-l-md cursor-pointer hover:bg-gray-50 has-[:checked]:bg-black has-[:checked]:text-white has-[:checked]:border-black">
                                    <input type="radio" name="gender" value="male" class="sr-only" checked>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="14" r="6"/>
                                        <path d="M18 8l4-4m0 0h-4m4 0v4"/>
                                    </svg>
                                    <span class="text-sm font-medium">МУЖСКОЙ</span>
                                </label>
                                <label class="flex-1 sm:flex-initial flex items-center justify-center px-4 py-2.5 border border-l-0 border-gray-300 rounded-r-md cursor-pointer hover:bg-gray-50 has-[:checked]:bg-black has-[:checked]:text-white has-[:checked]:border-black">
                                    <input type="radio" name="gender" value="female" class="sr-only">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="10" r="6"/>
                                        <path d="M12 16v6m-3-3h6"/>
                                    </svg>
                                    <span class="text-sm font-medium">ЖЕНСКИЙ</span>
                                </label>
                            </div>
                        </div>

                        <div class="relative sm:mt-6">
                            <input type="date" name="birth_date" id="birth_date"
                                   class="peer w-full sm:w-60 border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                   placeholder="Дата рождения"
                                   value="{{-- $passenger->birth_date --}}">
                            <label for="birth_date"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Дата рождения <span class="text-orange-500">*</span>
                            </label>
                        </div>
                    </div>

                    {{-- Чекбокс медработника --}}
                    <div class="flex items-start">
                        <input type="checkbox" name="is_medic" id="is_medic"
                               class="w-5 h-5 mt-0.5 border-gray-300 rounded text-orange-500 focus:ring-orange-500 flex-shrink-0">
                        <label for="is_medic" class="ml-3 text-xs sm:text-sm text-gray-500">
                            Пассажир является медицинским работником и готов оказать первую помощь в экстренном случае
                        </label>
                        <button type="button" class="ml-2 text-gray-400 hover:text-gray-600 flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 16v-4m0-4h.01"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Документы --}}
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Документы</h2>

                <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 mb-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Новый документ</h3>

                    {{-- Сообщение об ошибке (скрыто по умолчанию) --}}
                    <div id="doc-error" class="mb-4 hidden">
                        <div class="inline-flex items-center bg-orange-500 text-white text-sm rounded-md px-4 py-2 max-w-full">
                            <span>Поле обязательно для заполнения</span>
                            <button type="button" onclick="document.getElementById('doc-error').classList.add('hidden')" class="ml-3 text-white hover:text-orange-200 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Тип документа (кастомный select) --}}
                    <div class="relative mb-4">
                        <div class="relative">
                            <button type="button"
                                    id="doc-toggle"
                                    onclick="document.getElementById('doc-dropdown').classList.toggle('hidden')"
                                    class="w-full sm:w-72 border border-gray-300 rounded-md px-4 pt-5 pb-2 text-left focus:outline-none focus:border-gray-400 bg-white transition-colors">
                                <span class="absolute left-4 top-2 text-xs text-gray-500" id="doc-label">
                                    Тип документа <span class="text-orange-500">*</span>
                                </span>
                                <span class="text-gray-900 text-sm" id="doc-selected">Выберите тип</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown список (скрыт по умолчанию) --}}
                            <div id="doc-dropdown" class="hidden absolute top-full left-0 w-full sm:w-72 bg-white border border-gray-200 rounded-b-md shadow-lg z-50">
                                <ul class="py-0">
                                    <li>
                                        <button type="button" data-value="passport_rf"
                                                class="doc-option w-full text-left px-4 py-3 hover:bg-gray-100 text-sm text-gray-700">
                                            Паспорт РФ
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-value="foreign_passport"
                                                class="doc-option w-full text-left px-4 py-3 hover:bg-gray-100 text-sm text-gray-700 border-t border-gray-100">
                                            Заграничный паспорт
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-value="foreign_doc"
                                                class="doc-option w-full text-left px-4 py-3 hover:bg-gray-100 text-sm text-gray-700 border-t border-gray-100">
                                            Иностранный документ
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-value="residence_permit"
                                                class="doc-option w-full text-left px-4 py-3 hover:bg-gray-100 text-sm text-gray-700 border-t border-gray-100">
                                            Вид на жительство в РФ
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" data-value="passport_ussr"
                                                class="doc-option w-full text-left px-4 py-3 hover:bg-gray-100 text-sm text-gray-700 border-t border-gray-100">
                                            Паспорт СССР
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" name="document_type" id="document_type" value="">
                    </div>

                    {{-- Кнопка добавить ещё документ --}}
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <button type="button"
                                class="flex items-center text-sm font-semibold text-gray-900 hover:text-orange-500 tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            ДОБАВИТЬ ЕЩЁ ДОКУМЕНТ
                        </button>
                    </div>
                </div>

                <div class="flex justify-stretch sm:justify-end mt-6">
                    <button type="submit"
                            class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 text-white font-medium px-8 py-3 rounded-md transition-colors">
                        Сохранить
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Переключение radio-кнопок пола
        document.querySelectorAll('input[name="gender"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="gender"]').forEach(r => {
                    const label = r.closest('label');
                    if (r.checked) {
                        label.classList.add('bg-black', 'text-white', 'border-black');
                    } else {
                        label.classList.remove('bg-black', 'text-white', 'border-black');
                    }
                });
            });
        });

        // Функция показа ошибки на поле "Тип документа"
        function showDocError() {
            const toggle = document.getElementById('doc-toggle');
            const label = document.getElementById('doc-label');
            const selected = document.getElementById('doc-selected');
            const arrow = toggle.querySelector('svg');
            const error = document.getElementById('doc-error');

            error.classList.remove('hidden');

            toggle.classList.remove('border', 'border-gray-300');
            toggle.classList.add('border-2', 'border-orange-500');
            label.classList.remove('text-gray-500');
            label.classList.add('text-orange-500');
            selected.classList.remove('text-gray-900');
            selected.classList.add('text-orange-500');
            arrow.classList.remove('text-gray-500');
            arrow.classList.add('text-orange-500');
        }

        // Функция сброса ошибки
        function resetDocError() {
            const toggle = document.getElementById('doc-toggle');
            const label = document.getElementById('doc-label');
            const selected = document.getElementById('doc-selected');
            const arrow = toggle.querySelector('svg');
            const error = document.getElementById('doc-error');

            error.classList.add('hidden');

            toggle.classList.remove('border-2', 'border-orange-500');
            toggle.classList.add('border', 'border-gray-300');
            label.classList.remove('text-orange-500');
            label.classList.add('text-gray-500');
            selected.classList.remove('text-orange-500');
            selected.classList.add('text-gray-900');
            arrow.classList.remove('text-orange-500');
            arrow.classList.add('text-gray-500');
        }

        // Выбор типа документа
        document.querySelectorAll('.doc-option').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('doc-selected').textContent = this.textContent.trim();
                document.getElementById('document_type').value = this.dataset.value;
                document.getElementById('doc-dropdown').classList.add('hidden');
                resetDocError();
            });
        });

        // Закрытие dropdown при клике вне
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('doc-dropdown');
            const toggle = document.getElementById('doc-toggle');
            if (dropdown && !dropdown.contains(e.target) && !toggle.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Валидация формы при отправке
        document.getElementById('passenger-form').addEventListener('submit', function(e) {
            const docType = document.getElementById('document_type').value;
            if (!docType) {
                e.preventDefault();
                showDocError();
            }
        });
    </script>
    </body>
    </html>

@endsection
