@extends('layout.admin')

@section('title', 'Импорт пользователей')

@section('page-title', 'Импорт пользователей')
@section('page-description', 'Загрузка XLSX и генерация PDF с логинами')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl">

            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <input
                        type="file"
                        name="file"
                        accept=".xlsx"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 focus:border-red-600 focus:outline-none transition"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 transition font-semibold"
                >
                    Загрузить и обработать
                </button>
            </form>

        </div>

        <div class="bg-black/40 backdrop-blur-xl border border-red-900/30 rounded-2xl p-6 shadow-xl">

            <h3 class="text-lg font-bold mb-4">
                Сгенерированные файлы
            </h3>

            <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2">

                @forelse($files as $file)
                    <div class="flex items-center justify-between bg-slate-900 px-4 py-3 rounded-xl border border-slate-800">

                <span class="text-sm truncate">
                    {{ basename($file) }}
                </span>

                        <div class="flex items-center gap-2">

                            <a
                                href="{{ route('admin.users.pdf.view', basename($file)) }}"
                                target="_blank"
                                class="px-3 py-1 text-sm rounded-lg bg-slate-700 hover:bg-slate-600 transition"
                            >
                                Открыть
                            </a>

                            <a
                                href="{{ route('admin.users.pdf.download', basename($file)) }}"
                                class="px-3 py-1 text-sm rounded-lg bg-red-600 hover:bg-red-700 transition"
                            >
                                Скачать
                            </a>
                            <form method="POST" action="{{ route('admin.pdf.delete', basename($file)) }}">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 text-sm rounded-lg bg-red-800 hover:bg-red-900 transition">
                                    Удалить
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="text-slate-500 text-sm">
                        Пока нет сгенерированных файлов
                    </p>
                @endforelse

            </div>

        </div>
    </div>
@endsection
