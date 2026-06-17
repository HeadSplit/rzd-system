@extends('layout.index')

@section('title', 'Моя задача')

@section('content')

    <div class="max-w-3xl mx-auto p-6">
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 shadow-lg">

            <h2 class="text-2xl font-semibold mb-6 text-white">
                Ваша задача
            </h2>

            <div class="bg-zinc-800/60 rounded-xl p-5 mb-6 border border-zinc-700">
                <p class="text-slate-300 leading-relaxed">
                    {{ $task->description }}
                </p>
            </div>

            <div class="mb-6">
                @if($task->status === 'pending')
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-500/10 text-yellow-400 text-sm border border-yellow-500/20">
                        ⏳ В ожидании
                    </div>
                @elseif($task->status === 'passed')
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-500/10 text-green-400 text-sm border border-green-500/20">
                        ✅ Выполнено
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-sm border border-red-500/20">
                        ❌ Ошибка
                    </div>
                @endif
            </div>

            @if($task->user_answers)
                <div class="mt-6 border-t border-zinc-800 pt-6">
                    <h3 class="text-sm text-slate-400 mb-3 uppercase tracking-wide">
                        Ваш ответ
                    </h3>

                    <div class="bg-zinc-800/50 rounded-xl p-4 border border-zinc-700 space-y-2 text-sm text-slate-300">

                        <div class="flex justify-between">
                            <span class="text-slate-500">Маршрут</span>
                            <span class="font-medium text-white">
                            {{ $task->user_answers['from'] }} → {{ $task->user_answers['to'] }}
                        </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500">Места</span>
                            <span>
                            {{ implode(', ', $task->user_answers['seats'] ?? []) }}
                        </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500">Пассажир ID</span>
                            <span>
                            {{ $task->user_answers['passanger_id'] ?? '—' }}
                        </span>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection
