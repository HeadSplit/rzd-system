<?php

namespace App\Services;

use App\Models\Group;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelFioImporterService
{
    public function parse(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $start = null;
        foreach ($rows as $i => $row) {
            if (isset($row[0]) && trim($row[0]) === '№п/п') {
                $start = $i + 1;
                break;
            }
        }

        if ($start === null) return [];

        $fios = [];
        for ($i = $start; $i < count($rows); $i++) {
            $fio = trim($rows[$i][1] ?? '');
            if ($fio !== '') {
                $fios[] = $fio;
            }
        }

        return $fios;
    }

    public function createGroup(string $groupName, string $fileName): Group
    {
        return Group::create([
            'name' => $groupName,
            'filename' => $fileName,
        ]);
    }
}
