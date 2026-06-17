@extends('layout.admin')

@section('title', 'Группы')

@section('page-title', 'Группы пользователей')
@section('page-description', 'Список всех импортированных групп')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($groups as $group)
            <div class="p-6 rounded-2xl bg-black/40 border border-red-900/30">

                <a href="{{ route('admin.groups.show', $group->id) }}"
                   class="block hover:bg-black/60 transition rounded-xl p-2 -m-2">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold">
                            {{ $group->name }}
                        </h3>

                        <span class="text-sm text-slate-400">
                    {{ $group->users_count }} чел
                </span>
                    </div>

                    <p class="text-xs text-slate-500">
                        Создана: {{ $group->created_at->format('d.m.Y H:i') }}
                    </p>

                </a>

                <form method="POST" action="{{ route('admin.groups.delete', $group->id) }}" class="mt-4">
                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Удалить группу и всех пользователей?')"
                        class="w-full py-2 rounded-xl bg-red-800 hover:bg-red-900 transition text-sm"
                    >
                        Удалить группу
                    </button>
                </form>

            </div>
        @empty
            <p class="text-slate-500">
                Группы не найдены
            </p>
        @endforelse
    </div>
@endsection
