@extends('layout.admin')

@section('title', 'Билет #' . $ticket->id)

@section('page-title', 'Билет #' . $ticket->id)
@section('page-description', 'Подробная информация')

@section('content')

    <div class="space-y-6">
        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6 flex justify-between items-start">

            <div>
                <p class="text-slate-400 text-sm">Маршрут</p>
                <h3 class="text-xl font-bold">
                    {{ $ticket->fromStation->name }} → {{ $ticket->toStation->name }}
                </h3>

                <p class="text-xs text-slate-500 mt-2">
                    {{ \Carbon\Carbon::parse($ticket->from_date)->format('d.m.Y H:i') }}
                    —
                    {{ \Carbon\Carbon::parse($ticket->to_date)->format('d.m.Y H:i') }}
                </p>
                <p class="text-xs text-slate-500 mt-2">
                    Места:
                        {{ collect($ticket->seats)->pluck('number')->join(', ') }}
                </p>
            </div>

            <form method="POST" action="{{ route('admin.tickets.delete', $ticket->id) }}">
                @csrf
                @method('DELETE')

                <button
                    onclick="return confirm('Удалить билет?')"
                    class="px-4 py-2 rounded-xl bg-red-700 hover:bg-red-800 transition"
                >
                    Удалить
                </button>
            </form>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

            <div class="p-4 bg-slate-900 rounded-xl">
                Взрослые: {{ $ticket->adult_person }}
            </div>

            <div class="p-4 bg-slate-900 rounded-xl">
                Дети (с местом): {{ $ticket->child_with_place }}
            </div>

            <div class="p-4 bg-slate-900 rounded-xl">
                Дети (без места): {{ $ticket->child_without_place }}
            </div>

            <div class="p-4 bg-slate-900 rounded-xl">
                Инвалиды: {{ $ticket->place_for_invalid }}
            </div>

            <div class="p-4 bg-slate-900 rounded-xl">
                Семейные места: {{ $ticket->place_for_family }}
            </div>

        </div>

        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6">

            <h3 class="text-lg font-bold mb-4">Дополнительно</h3>

            <div class="space-y-2 text-sm text-slate-300">
                <p>Животные: {{ $ticket->pets ? 'Да' : 'Нет' }}</p>
                <p>Машина: {{ $ticket->car ? 'Да' : 'Нет' }}</p>
                <p>Мотоцикл: {{ $ticket->motorcycle ? 'Да' : 'Нет' }}</p>
            </div>

        </div>

        <div class="bg-black/40 border border-red-900/30 rounded-2xl p-6">

            <h3 class="text-lg font-bold mb-4">Связи</h3>

            <p class="text-sm">Пользователь: {{ $ticket->user->fullname ?? '—' }}</p>
            <p class="text-sm">Пассажир: {{ $ticket->passanger->name ?? '—' }}</p>

        </div>
    </div>
@endsection
