@extends('layout.index')

@section('content')
    @php
        if (!isset($passenger)) {
            $passenger = new \App\Models\Passanger();
        }

        $existingPassengersQuery = \App\Models\Passanger::where('user_id', auth()->id());
        if ($passenger->id) {
            $existingPassengersQuery->where('id', '!=', $passenger->id);
        }
        $existingPassengers = $existingPassengersQuery->get();
    @endphp

    <div class="bg-white border-b border-gray-200 px-3 sm:px-6 py-3 sm:py-4 flex items-center">
        <a href="{{ url()->previous() }}" class="text-gray-700 hover:text-black mr-3 sm:mr-4 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-base sm:text-lg font-medium text-center flex-1 pr-8">Данные пассажира</h1>
    </div>

    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8 flex flex-col lg:flex-row gap-4 lg:gap-8">

        <aside class="w-full lg:w-80 lg:flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="flex flex-col items-center pt-6 sm:pt-8 pb-4">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-200 rounded-full flex items-center justify-center mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-gray-900">
                        {{ $passenger->id ? $passenger->surname . ' ' . $passenger->name : 'НОВЫЙ ПАССАЖИР' }}
                    </h2>
                </div>

                <nav class="mt-2 flex lg:block overflow-x-auto border-t border-gray-100">
                    <a href="#" class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 bg-black text-white text-sm sm:text-base font-medium border-b-4 lg:border-b-0 lg:border-l-4 border-orange-500 whitespace-nowrap">
                        Документы и контакты
                    </a>
                    <a href="#" class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Бонусы и скидки
                    </a>
                    <a href="#" class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Проездные карты
                    </a>
                    <a href="#" class="flex-shrink-0 lg:block px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base text-gray-700 hover:bg-gray-50 border-b-4 lg:border-b-0 lg:border-l-4 border-transparent whitespace-nowrap">
                        Льготный проезд
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 min-w-0">
            {{-- ФОРМА СОХРАНЕНИЯ ПАССАЖИРА --}}
            <form action="{{ route('passenger.store') }}" method="POST" id="passenger-form">
                @csrf
                @if($passenger->id)
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $passenger->id }}">
                @endif
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900">Основная информация</h2>
                    <button type="button" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 mb-6 sm:mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="relative">
                            <input type="text" name="surname" id="surname"
                                   class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                   placeholder="Фамилия"
                                   value="{{ old('surname', $passenger->surname) }}">
                            <label for="surname"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Фамилия <span class="text-orange-500">*</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input type="text" name="name" id="name"
                                   class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                   placeholder="Имя"
                                   value="{{ old('name', $passenger->name) }}">
                            <label for="name"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Имя <span class="text-orange-500">*</span>
                            </label>
                        </div>

                        <div>
                            <div class="relative">
                                <input type="text" name="patronymic" id="patronymic"
                                       class="peer w-full border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                       placeholder="Отчество"
                                       value="{{ old('patronymic', $passenger->patronymic) }}">
                                <label for="patronymic"
                                       class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                    Отчество <span class="text-orange-500">*</span>
                                </label>
                            </div>
                            <div class="flex items-center mt-2">
                                <input type="checkbox" name="has_patronymic" id="has_patronymic"
                                       class="w-4 h-4 border-gray-300 rounded text-orange-500 focus:ring-orange-500"
                                    {{ old('has_patronymic', $passenger->has_patronymic) ? 'checked' : '' }}>
                                <label for="has_patronymic" class="ml-2 text-sm text-gray-600">
                                    Пассажир не имеет отчества
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-start gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Пол</label>
                            <div class="flex">
                                <label class="flex-1 sm:flex-initial flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-l-md cursor-pointer hover:bg-gray-50 has-[:checked]:bg-black has-[:checked]:text-white has-[:checked]:border-black {{ old('gender', $passenger->gender) == 'male' ? 'bg-black text-white border-black' : '' }}">
                                    <input type="radio" name="gender" value="male" class="sr-only" {{ old('gender', $passenger->gender) == 'male' ? 'checked' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="14" r="6"/>
                                        <path d="M18 8l4-4m0 0h-4m4 0v4"/>
                                    </svg>
                                    <span class="text-sm font-medium">МУЖСКОЙ</span>
                                </label>
                                <label class="flex-1 sm:flex-initial flex items-center justify-center px-4 py-2.5 border border-l-0 border-gray-300 rounded-r-md cursor-pointer hover:bg-gray-50 has-[:checked]:bg-black has-[:checked]:text-white has-[:checked]:border-black {{ old('gender', $passenger->gender) == 'female' ? 'bg-black text-white border-black' : '' }}">
                                    <input type="radio" name="gender" value="female" class="sr-only" {{ old('gender', $passenger->gender) == 'female' ? 'checked' : '' }}>
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
                                   value="{{ old('birth_date', $passenger->birth_date ? $passenger->birth_date->format('Y-m-d') : '') }}">
                            <label for="birth_date"
                                   class="absolute left-4 top-2 text-xs text-gray-500 transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-focus:top-2 peer-focus:text-xs">
                                Дата рождения <span class="text-orange-500">*</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="is_medical" id="is_medical"
                               class="w-5 h-5 mt-0.5 border-gray-300 rounded text-orange-500 focus:ring-orange-500 flex-shrink-0"
                            {{ old('is_medical', $passenger->is_medical) ? 'checked' : '' }}>
                        <label for="is_medical" class="ml-3 text-xs sm:text-sm text-gray-500">
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

                <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-3 sm:mb-4">Документы</h2>

                <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 mb-6">
                    <div class="flex gap-4 mb-6 border-b border-gray-200 pb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="doc_mode" value="new" class="w-4 h-4 text-orange-500 focus:ring-orange-500" checked>
                            <span class="ml-2 text-sm font-medium text-gray-700">Новый документ</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="doc_mode" value="existing" class="w-4 h-4 text-orange-500 focus:ring-orange-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Существующий документ</span>
                        </label>
                    </div>

                    <div id="new-document-block">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Новый документ</h3>

                        <div id="doc-error" class="mb-4 hidden">
                            <div class="inline-flex items-center bg-orange-500 text-white text-sm rounded-md px-4 py-2 max-w-full">
                                <span>Пожалуйста, выберите тип документа</span>
                                <button type="button" onclick="document.getElementById('doc-error').classList.add('hidden')" class="ml-3 text-white hover:text-orange-200 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="relative mb-4">
                            <div class="relative">
                                <select name="document" id="document_type"
                                        class="w-full sm:w-72 border border-gray-300 rounded-md px-4 pt-5 pb-2 text-gray-900 appearance-none bg-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                                    <option value="" disabled {{ !$passenger->document ? 'selected' : '' }}>Выберите тип документа</option>
                                    <option value="passport_rf" {{ old('document', $passenger->document) == 'passport_rf' ? 'selected' : '' }}>Паспорт РФ</option>
                                    <option value="foreign_passport" {{ old('document', $passenger->document) == 'foreign_passport' ? 'selected' : '' }}>Заграничный паспорт</option>
                                    <option value="foreign_doc" {{ old('document', $passenger->document) == 'foreign_doc' ? 'selected' : '' }}>Иностранный документ</option>
                                    <option value="residence_permit" {{ old('document', $passenger->document) == 'residence_permit' ? 'selected' : '' }}>Вид на жительство в РФ</option>
                                    <option value="passport_ussr" {{ old('document', $passenger->document) == 'passport_ussr' ? 'selected' : '' }}>Паспорт СССР</option>
                                </select>
                                <label for="document_type"
                                       class="absolute left-4 top-2 text-xs text-gray-500 pointer-events-none">
                                    Тип документа <span class="text-orange-500">*</span>
                                </label>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>

                            <div id="doc-fields" class="{{ $passenger->document ? '' : 'hidden' }} mt-4 flex flex-col sm:flex-row sm:items-end gap-3">
                                <div class="relative">
                                    <input type="text" name="series" id="doc_series"
                                           class="peer w-32 border border-gray-300 rounded-md px-3 pt-4 pb-1.5 text-sm text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                           placeholder="Серия"
                                           value="{{ old('series', $passenger->series) }}">
                                    <label for="doc_series"
                                           class="absolute left-4 top-2 text-xs text-gray-500 transition-all">
                                        Серия <span class="text-orange-500">*</span>
                                    </label>
                                </div>

                                <div class="relative {{ $passenger->series ? '' : 'hidden' }}" id="doc-number-wrapper">
                                    <input type="text" name="number" id="doc_number"
                                           class="peer w-44 border border-gray-300 rounded-md px-3 pt-4 pb-1.5 text-sm text-gray-900 placeholder-transparent focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                           placeholder="Номер"
                                           value="{{ old('number', $passenger->number) }}">
                                    <label for="doc_number"
                                           class="absolute left-4 top-2 text-xs text-gray-500 transition-all">
                                        Номер <span class="text-orange-500">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="existing-document-block" class="hidden">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Выберите существующий документ</h3>

                        <div class="relative mb-4">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <select id="existing_document_id"
                                        class="flex-1 border border-gray-300 rounded-md px-4 py-2 text-gray-900 bg-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                                    <option value="">-- Выберите документ --</option>
                                    @foreach($existingPassengers as $doc)
                                        <option value="{{ $doc->id }}">
                                            {{ $doc->surname }} {{ $doc->name }} -
                                            @switch($doc->document)
                                                @case('passport_rf') Паспорт РФ @break
                                                @case('foreign_passport') Загранпаспорт @break
                                                @case('foreign_doc') Иностранный документ @break
                                                @case('residence_permit') Вид на жительство @break
                                                @case('passport_ussr') Паспорт СССР @break
                                                @default {{ $doc->document }}
                                            @endswitch
                                            ({{ $doc->series }} {{ $doc->number }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="apply-document-btn"
                                        class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                        disabled>
                                    Выбрать
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Выберите документ из списка и нажмите "Выбрать" для копирования данных</p>
                        </div>
                    </div>

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

                <div class="flex justify-stretch sm:justify-end mt-6 gap-3">
                    <button type="submit" name="action" value="save"
                            class="flex-1 sm:flex-initial bg-orange-500 hover:bg-orange-600 text-white font-medium px-8 py-3 rounded-md transition-colors">
                        Сохранить
                    </button>
                </div>
            </form>

            {{-- ФОРМА ДЛЯ ПРОДОЛЖЕНИЯ (отправка на ticket.store) --}}
                <form action="{{ route('ticket.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="passanger_id" id="passanger_id" class="passanger_id" value="">
                    <div class="flex justify-stretch sm:justify-end">
                        <button type="submit"
                                class="flex-1 sm:flex-initial bg-gray-500 hover:bg-gray-600 text-white font-medium px-8 py-3 rounded-md transition-colors text-center">
                            Продолжить
                        </button>
                    </div>
                </form>
            @if(!isset($passenger->id))
                <div class="flex justify-stretch sm:justify-end mt-4">
                    <button disabled
                            class="flex-1 sm:flex-initial bg-gray-300 text-white font-medium px-8 py-3 rounded-md text-center cursor-not-allowed">
                        Продолжить (сначала сохраните пассажира)
                    </button>
                </div>
            @endif
        </main>
    </div>

    <script>
        const docFields = document.getElementById('doc-fields');
        const seriesInput = document.getElementById('doc_series');
        const numberWrapper = document.getElementById('doc-number-wrapper');
        const numberInput = document.getElementById('doc_number');
        const documentTypeSelect = document.getElementById('document_type');
        const idInput = document.getElementById('passanger_id');
        const docError = document.getElementById('doc-error');

        const newDocumentBlock = document.getElementById('new-document-block');
        const existingDocumentBlock = document.getElementById('existing-document-block');
        const docModeRadios = document.querySelectorAll('input[name="doc_mode"]');
        const existingDocumentSelect = document.getElementById('existing_document_id');
        const applyDocumentBtn = document.getElementById('apply-document-btn');

        function toggleDocumentMode() {
            const selectedMode = document.querySelector('input[name="doc_mode"]:checked').value;

            if (selectedMode === 'new') {
                newDocumentBlock.classList.remove('hidden');
                existingDocumentBlock.classList.add('hidden');
                if (existingDocumentSelect) existingDocumentSelect.disabled = true;
                if (applyDocumentBtn) applyDocumentBtn.disabled = true;
                if (documentTypeSelect) documentTypeSelect.disabled = false;
                if (seriesInput) seriesInput.disabled = false;
                if (numberInput) numberInput.disabled = false;
            } else {
                newDocumentBlock.classList.add('hidden');
                existingDocumentBlock.classList.remove('hidden');
                if (existingDocumentSelect) existingDocumentSelect.disabled = false;
                if (documentTypeSelect) documentTypeSelect.disabled = true;
                if (seriesInput) seriesInput.disabled = true;
                if (numberInput) numberInput.disabled = true;

                if (existingDocumentSelect.value) {
                    applyDocumentBtn.disabled = false;
                } else {
                    applyDocumentBtn.disabled = true;
                }
            }
        }

        docModeRadios.forEach(radio => {
            radio.addEventListener('change', toggleDocumentMode);
        });

        if (existingDocumentSelect) {
            existingDocumentSelect.addEventListener('change', function() {
                if (this.value) {
                    applyDocumentBtn.disabled = false;
                } else {
                    applyDocumentBtn.disabled = true;
                }
            });
        }

        if (applyDocumentBtn) {
            applyDocumentBtn.addEventListener('click', function() {
                const selectedId = existingDocumentSelect.value;
                if (!selectedId) return;

                this.disabled = true;
                this.textContent = 'Загрузка...';

                fetch(`/passenger/${selectedId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Ошибка загрузки');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('passanger_id').value = data.id;
                        document.getElementById('surname').value = data.surname;
                        document.getElementById('name').value = data.name;
                        document.getElementById('patronymic').value = data.patronymic || '';

                        const hasPatronymicCheckbox = document.getElementById('has_patronymic');
                        hasPatronymicCheckbox.checked = data.has_patronymic;

                        const genderRadios = document.querySelectorAll('input[name="gender"]');
                        genderRadios.forEach(radio => {
                            const label = radio.closest('label');
                            if (radio.value === data.gender) {
                                radio.checked = true;
                                label.classList.add('bg-black', 'text-white', 'border-black');
                            } else {
                                label.classList.remove('bg-black', 'text-white', 'border-black');
                            }
                        });

                        if (data.birth_date) {
                            let birthDate = data.birth_date;
                            if (birthDate.includes('.')) {
                                const parts = birthDate.split('.');
                                if (parts.length === 3) {
                                    birthDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                                }
                            }
                            document.getElementById('birth_date').value = birthDate;
                        }

                        document.getElementById('is_medical').checked = data.is_medical;

                        if (data.document) {
                            documentTypeSelect.value = data.document;
                            toggleDocFields();
                        }
                        if (data.series) {
                            seriesInput.value = data.series;
                            const event = new Event('input', { bubbles: true });
                            seriesInput.dispatchEvent(event);
                        }
                        if (data.number) {
                            numberInput.value = data.number;
                        }
                        if (data.id)
                        {
                            idInput.value = data.id;
                        }

                        const successMsg = document.createElement('div');
                        successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                        successMsg.innerHTML = 'Данные пассажира загружены';
                        document.body.appendChild(successMsg);
                        setTimeout(() => successMsg.remove(), 3000);

                        document.querySelector('input[name="doc_mode"][value="new"]').checked = true;
                        toggleDocumentMode();
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                        errorMsg.innerHTML = 'Ошибка загрузки документа';
                        document.body.appendChild(errorMsg);
                        setTimeout(() => errorMsg.remove(), 3000);
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.textContent = 'Выбрать';
                    });
            });
        }

        function toggleDocFields() {
            if (documentTypeSelect.value) {
                docFields.classList.remove('hidden');
                if (docError) docError.classList.add('hidden');
                documentTypeSelect.classList.remove('border-2', 'border-orange-500');
                documentTypeSelect.classList.add('border', 'border-gray-300');
            } else {
                docFields.classList.add('hidden');
                if (seriesInput) seriesInput.value = '';
                if (numberInput) numberInput.value = '';
                if (numberWrapper) numberWrapper.classList.add('hidden');
            }
        }

        if (seriesInput) {
            seriesInput.addEventListener('input', function () {
                if (this.value.trim().length > 0) {
                    numberWrapper.classList.remove('hidden');
                } else {
                    numberWrapper.classList.add('hidden');
                    if (numberInput) numberInput.value = '';
                }
            });

            if (seriesInput.value.trim().length > 0) {
                numberWrapper.classList.remove('hidden');
            }
        }

        if (documentTypeSelect) {
            documentTypeSelect.addEventListener('change', toggleDocFields);
        }

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

        toggleDocumentMode();
    </script>
@endsection
