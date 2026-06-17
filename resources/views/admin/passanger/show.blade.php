@extends('layout.admin')

@section('title', 'Пассажир #' . $passanger->id)

@section('page-title', 'Пассажир')
@section('page-description', 'Подробная информация')

@section('content')

    <div class="space-y-6">


        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6 flex justify-between items-start">

            <div>
                <h3 class="text-xl font-bold">
                    {{ $passanger->surname }} {{ $passanger->name }}
                    @if($passanger->has_patronymic)
                        {{ $passanger->patronymic }}
                    @endif
                </h3>

                <p class="text-sm text-slate-400 mt-1">
                    {{ \App\Models\Passanger::GENDERS[$passanger->gender] ?? $passanger->gender }}
                </p>
            </div>

            <form method="POST" action="{{ route('admin.passangers.delete', $passanger->id) }}">
                @csrf
                @method('DELETE')

                <button
                    onclick="return confirm('Удалить пассажира?')"
                    class="px-4 py-2 rounded-xl bg-red-700 hover:bg-red-800 transition"
                >
                    Удалить
                </button>
            </form>

        </div>

        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6">

            <h3 class="text-lg font-bold mb-4">Основная информация</h3>

            <div class="space-y-2 text-sm text-slate-300">
                <p>Дата рождения: {{ \Carbon\Carbon::parse($passanger->birth_date)->format('d.m.Y') }}</p>
                <p>Пользователь: {{ $passanger->user?->fullname ?? '—' }}</p>
                <p>Медик: {{ $passanger->is_medical ? 'Да' : 'Нет' }}</p>
            </div>

        </div>

        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6">

            <h3 class="text-lg font-bold mb-4">Документ</h3>

            <div class="space-y-2 text-sm text-slate-300">
                <p>Тип: {{ \App\Models\Passanger::DOCUMENT_TYPES[$passanger->document] ?? $passanger->document }}</p>
                <p>Серия: {{ $passanger->series }}</p>
                <p>Номер: {{ $passanger->number }}</p>
            </div>

        </div>
    </div>
@endsection
