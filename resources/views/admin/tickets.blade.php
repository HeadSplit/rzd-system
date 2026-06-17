@extends('layout.admin')

@section('title', 'Билеты')

@section('page-title', 'Билеты')
@section('page-description', 'Все билеты в системе')

@section('content')

    <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="text-left py-3">ID</th>
                    <th class="text-left py-3">Пользователь</th>
                    <th class="text-left py-3">Пассажир</th>
                    <th class="text-left py-3">Откуда</th>
                    <th class="text-left py-3">Куда</th>
                    <th class="text-left py-3">Дата отпр.</th>
                    <th class="text-left py-3">Дата приб.</th>
                    <th class="text-right py-3">Действия</th>
                </tr>
                </thead>

                <tbody>
                @forelse($tickets as $ticket)
                    <tr class="border-b border-slate-900 hover:bg-slate-900/50 transition">
                        <td class="py-3">{{ $ticket->id }}</td>
                        <td class="py-3">{{ $ticket->user?->fullname ?? '—' }}</td>
                        <td class="py-3">{{ $ticket->passanger?->name ?? '—' }}</td>
                        <td class="py-3">{{ $ticket->fromStation->name }}</td>
                        <td class="py-3">{{ $ticket->toStation->name }}</td>
                        <td class="py-3">{{ $ticket->from_date->format('d.m.Y H:i') }}</td>
                        <td class="py-3">{{ $ticket->to_date->format('d.m.Y H:i') }}</td>
                        <td class="py-3 text-right">

                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                   class="px-3 py-1 text-sm rounded-lg bg-slate-700 hover:bg-slate-600 transition">
                                    Подробнее
                                </a>

                                <form method="POST" action="{{ route('admin.tickets.delete', $ticket->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Удалить билет?')"
                                        class="px-3 py-1 text-sm rounded-lg bg-red-800 hover:bg-red-900 transition"
                                    >
                                        Удалить
                                    </button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-4 text-slate-500 text-center">
                            Билеты не найдены
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection
