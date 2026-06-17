@extends('layout.admin')

@section('title', 'Пассажиры')

@section('page-title', 'Пассажиры')
@section('page-description', 'Список всех пассажиров')

@section('content')

    <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="text-left py-3">ID</th>
                    <th class="text-left py-3">ФИО</th>
                    <th class="text-left py-3">Пользователь</th>
                    <th class="text-left py-3">Документ</th>
                    <th class="text-left py-3">Дата рождения</th>
                    <th class="text-right py-3">Действия</th>
                </tr>
                </thead>

                <tbody>
                @forelse($passangers as $p)
                    <tr class="border-b border-slate-900 hover:bg-slate-900/50 transition">

                        <td class="py-3">{{ $p->id }}</td>

                        <td class="py-3">
                            {{ $p->surname }} {{ $p->name }}
                            @if($p->has_patronymic)
                                {{ $p->patronymic }}
                            @endif
                        </td>

                        <td class="py-3">
                            {{ $p->user?->fullname ?? '—' }}
                        </td>

                        <td class="py-3">
                            {{ \App\Models\Passanger::DOCUMENT_TYPES[$p->document] ?? $p->document }}
                        </td>

                        <td class="py-3">
                            {{ \Carbon\Carbon::parse($p->birth_date)->format('d.m.Y') }}
                        </td>

                        <td class="py-3 text-right">

                            <a href="{{ route('admin.passangers.show', $p->id) }}"
                               class="px-3 py-1 text-sm rounded-lg bg-slate-700 hover:bg-slate-600 transition">
                                Открыть
                            </a>

                            <form method="POST" action="{{ route('admin.passangers.delete', $p->id) }}" class="inline-block">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Удалить пассажира?')"
                                    class="px-3 py-1 text-sm rounded-lg bg-red-800 hover:bg-red-900 transition"
                                >
                                    Удалить
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-slate-500">
                            Пассажиры не найдены
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection
