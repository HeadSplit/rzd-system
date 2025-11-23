<?php

namespace App\Console\Commands;

use App\Jobs\ImportFioJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ScanXlsxFolder extends Command
{
    protected $signature = 'scan:xlsx';
    protected $description = 'Сканирует папку xlsx/import и запускает импорт';

    public function handle()
    {
        $files = Storage::files('xlsx/import');

        if(count($files) == 0){
            $this->info('Файлы не найдены');
        }

        foreach ($files as $file) {
            if (!str_ends_with($file, '.xlsx')) continue;

            ImportFioJob::dispatch($file);

            $this->info("Импорт запущен для $file");
        }
    }
}
