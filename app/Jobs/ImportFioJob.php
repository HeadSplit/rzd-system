<?php

namespace App\Jobs;

use App\Services\ExcelFioImporterService;
use App\Services\UserGeneratorService;
use App\Services\UserPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class   ImportFioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $path)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        ExcelFioImporterService $importer,
        UserGeneratorService $generator,
    ): void
    {
        $fileName = basename($this->path);
        $groupName = pathinfo($fileName, PATHINFO_FILENAME);

       $group = $generator->createGroup($groupName, $fileName);

        $processedPath = 'xlsx/processed/' . $fileName;

        $fullPath = storage_path('app/' . $this->path);


        $fios = $importer->parse($fullPath);

        if (empty($fios)) {
            echo "Файл {$this->path} пустой или колонка выбрана неверно\n";
            Log::warning("Файл {$this->path} пустой или колонка выбрана неверно");
        } else {
            echo "ФИО из файла {$this->path}:\n";
            foreach ($fios as $i => $fio) {
                echo ($i + 1) . ". $fio\n";
                Log::info("ФИО: $fio");
            }
        }

        foreach ($fios as $fio) {
            $result = $generator->createFromFio($fio, $group->id);
            if ($result) $createdUsers[] = $result;
        }

        if(!empty($createdUsers)) {
            $pdfPath = $generator->generatePdf($createdUsers, $groupName . '.pdf');
            Log::info("Pdf $groupName сформирован");
        }

        Storage::move($this->path, $processedPath);
    }
}
