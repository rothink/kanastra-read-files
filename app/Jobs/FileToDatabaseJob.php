<?php

namespace App\Jobs;

use App\Services\RemessaService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class FileToDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app()->make(RemessaService::class)->fileToDatabase();
//        Log::info('Buscando arquivos..' . Carbon::now());
//        $files = Storage::disk('local')->allFiles('/remessa');
//        if (empty($files)) {
//            Log::info('Nenhuma remessa encontrada.');
//        }
//        Log::info(count($files) .  ' remessa(s) encontrada(s).');
//        foreach ($files as $file) {
//            $skip = 0;
//            SimpleExcelReader::create(storage_path("app/" . $file))
//                ->useDelimiter(',')
//                ->useHeaders(['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtID'])
//                ->getRows()
//                ->skip($skip)
//                ->take(1000) //limite para teste local
//                ->each(
//                    function ($row) use ($skip) {
//                        dd($row);
//                        app()->make(RemessaService::class)->saveRemessa($row);
//                        $skip += 1000;
//                    }
//                );
//
//        }
//        Log::info('removendo remessas');
//        foreach ($files as $file) {
//            Storage::disk('local')->delete($file);
//        }
    }
}
