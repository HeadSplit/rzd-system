@extends('layout.admin')

@section('title', 'Результаты')

@section('content')

    <div class="max-w-6xl mx-auto p-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Результаты</h1>

            <form method="GET">
                <select name="group_id"
                        onchange="this.form.submit()"
                        class="bg-zinc-900 border border-zinc-700 text-sm rounded-lg px-3 py-2 text-white">

                    <option value="">Все группы</option>

                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $groupId == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                    @endforeach

                </select>
            </form>
        </div>

        @forelse($users as $user)

            @php
                $task = $user->task;
                $correct = $task?->correct_answers ?? [];
                $answer = $task?->user_answers ?? [];
            @endphp

            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 mb-4">

                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-white font-semibold">
                            {{ $user->name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $user->email }} · {{ $user->group->name ?? 'Без группы' }}
                        </p>
                    </div>

                    @if(!$task)
                        <span class="text-xs text-slate-400">Нет задачи</span>
                    @elseif($task->is_answer_correct)
                        <span class="px-3 py-1 rounded-full text-xs bg-green-500/10 text-green-400 border border-green-500/20">
                        ✅ Верно
                    </span>
                    @elseif($task->status === 'pending')
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                        ⏳ В процессе
                    </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs bg-red-500/10 text-red-400 border border-red-500/20">
                        ❌ Ошибка
                    </span>
                    @endif
                </div>

                @if($task)

                    <div class="bg-zinc-800/50 border border-zinc-700 rounded-xl p-4 mb-4">

                        <div class="grid grid-cols-3 gap-4 text-sm">

                            <div>
                                <p class="text-slate-500 text-xs mb-1">Маршрут</p>
                                <p class="text-white">
                                    {{ $correct['from'] ?? '—' }} → {{ $correct['to'] ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500 text-xs mb-1">Отправление</p>
                                <p class="text-white">
                                    {{ isset($correct['departure_time']) ? \Illuminate\Support\Carbon::parse($correct['departure_time'])->format('d.m.Y H:i') : '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-slate-500 text-xs mb-1">Прибытие</p>
                                <p class="text-white">
                                    {{ isset($correct['arrival_time']) ? \Illuminate\Support\Carbon::parse($correct['arrival_time'])->format('d.m.Y H:i') : '—' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">

                        <div class="bg-zinc-800/40 border border-zinc-700 rounded-xl p-4">
                            <p class="text-slate-400 text-xs mb-3 uppercase">Ответ пользователя</p>

                            <p>
                                Класс:
                                <span class="text-white">
                                {{ isset($answer['wagon_class']) ? \App\Enums\WagonServiceClassEnum::from($answer['wagon_class'])->label() : '—' }}
                            </span>
                            </p>

                            <p>
                                Места:
                                <span class="text-white">
                                {{ implode(', ', $answer['seats'] ?? []) ?: '—' }}
                            </span>
                            </p>

                            <p>
                                Маршрут:
                                <span class="text-white">
                                {{ ($answer['from_station_id'] ?? '—') }} → {{ ($answer['to_station_id'] ?? '—') }}
                            </span>
                            </p>

                            <p>
                                Пассажир:
                                <span class="text-white">
                                {{ ($answer['passanger']['surname'] ?? '') }}
                                    {{ ($answer['passanger']['name'] ?? '') }}
                                    {{ ($answer['passanger']['patronymic'] ?? '') }}
                            </span>
                            </p>

                            <p>
                                Документ:
                                <span class="text-white">
                                {{ $answer['document']['type'] ?? '' }}
                                    {{ $answer['document']['series'] ?? '' }}
                                    {{ $answer['document']['number'] ?? '' }}
                            </span>
                            </p>
                        </div>

                        <div class="bg-zinc-800/40 border border-zinc-700 rounded-xl p-4">
                            <p class="text-slate-400 text-xs mb-3 uppercase">Правильный ответ</p>

                            <p>
                                Класс:
                                <span class="text-white">
                                {{ isset($correct['wagon_class']) ? \App\Enums\WagonServiceClassEnum::from($correct['wagon_class'])->label() : '—' }}
                            </span>
                            </p>

                            <p>
                                Места:
                                <span class="text-white">
                                {{ implode(', ', $correct['seats'] ?? []) ?: '—' }}
                            </span>
                            </p>

                            <p>
                                Маршрут:
                                <span class="text-white">
                                {{ ($correct['from_station_id'] ?? '—') }} → {{ ($correct['to_station_id'] ?? '—') }}
                            </span>
                            </p>

                            <p>
                                Пассажир:
                                <span class="text-white">
                                {{ ($correct['passanger']['surname'] ?? '') }}
                                    {{ ($correct['passanger']['name'] ?? '') }}
                                    {{ ($correct['passanger']['patronymic'] ?? '') }}
                            </span>
                            </p>

                            <p>
                                Документ:
                                <span class="text-white">
                                {{ $correct['document']['type'] ?? '' }}
                                    {{ $correct['document']['series'] ?? '' }}
                                    {{ $correct['document']['number'] ?? '' }}
                            </span>
                            </p>
                        </div>

                    </div>

                @endif

            </div>

        @empty
            <div class="text-center text-slate-500 py-20">
                Нет пользователей
            </div>
        @endforelse

    </div>

@endsection
