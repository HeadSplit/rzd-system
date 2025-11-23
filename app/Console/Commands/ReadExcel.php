<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReadExcel extends Command
{
    protected $signature = 'import:fio {file}';
    protected $description = 'Импорт ФИО из Excel в storage/app/xlsx';

    public function handle()
    {
        $filename = $this->argument('file');
        $filePath = storage_path("app/xls/{$filename}.xlsx");
        if (!file_exists($filePath)) {
            $this->error("Файл {$filename} не найден в storage/app/xlsx");
            return 1;
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $startIndex = null;
        foreach ($data as $i => $row) {
            if (isset($row[0]) && trim($row[0]) === '№п/п') {
                $startIndex = $i + 1;
                break;
            }
        }

        if ($startIndex === null) {
            $this->error('Строка №п/п не найдена');
            return 1;
        }

        $fios = [];
        for ($i = $startIndex; $i < count($data); $i++) {
            $fio = trim($data[$i][1] ?? '');
            if ($fio !== '') {
                $fios[] = [$fio];
            }
        }

        $this->table(['ФИО'], $fios);
        return 0;
    }
}
