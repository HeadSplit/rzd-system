@extends('layout.admin')

@section('title', $group->name)

@section('page-title', $group->name)
@section('page-description', 'Подробная информация о группе')

@section('content')

    <div class="space-y-6">
        text

        <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl flex items-center justify-between">

            <div>
                <p class="text-sm text-slate-400 mb-1">Название группы</p>
                <h3 class="text-xl font-bold">{{ $group->name }}</h3>

                <p class="text-xs text-slate-500 mt-2">
                    Создана: {{ $group->created_at->format('d.m.Y H:i') }}
                </p>

                <p class="text-xs text-slate-500">
                    Пользователей: {{ $group->users->count() }}
                </p>
            </div>

            <form method="POST" action="{{ route('admin.groups.delete', $group->id) }}">
                @csrf
                @method('DELETE')

                <button
                    onclick="return confirm('Удалить группу и всех пользователей?')"
                    class="px-4 py-2 rounded-xl bg-red-700 hover:bg-red-800 transition"
                >
                    Удалить группу
                </button>
            </form>

        </div>

        <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl">

            <h3 class="text-lg font-bold mb-4">Пользователи</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="text-left py-3">ID</th>
                        <th class="text-left py-3">ФИО</th>
                        <th class="text-left py-3">Логин</th>
                        <th class="text-right py-3">Действия</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($group->users as $user)
                        <tr class="border-b border-slate-900">
                            <td class="py-3">{{ $user->id }}</td>
                            <td class="py-3">{{ $user->fullname }}</td>
                            <td class="py-3">{{ $user->login }}</td>
                            <td class="py-3 text-right">

                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Удалить пользователя?')"
                                        class="px-3 py-1 text-sm rounded-lg bg-red-800 hover:bg-red-900 transition"
                                    >
                                        Удалить
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-slate-500">
                                Пользователи отсутствуют
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection


