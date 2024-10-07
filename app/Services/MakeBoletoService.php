<?php

namespace App\Services;

use App\Models\Remessa;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MakeBoletoService
{
    /**
     * @param Remessa $remessa
     * @return bool|null
     */
    public function makeBoleto(Remessa $remessa): bool|null
    {
        try {
            $response = Http::get('https://run.mocky.io/v3/99dcb239-79b9-4719-9c27-f38add127b21');
            if ($response->status() == Response::HTTP_CREATED) {
                $file = Storage::disk('local')->get('/boleto-fake/boleto-fake.pdf');
                $path = "/boleto-maked/" . $remessa->debtID . '.pdf';
                Storage::disk('local')->put($path, $file);
                Log::info('boleto gerado e armazenando no storage' . $remessa->debtID);
                return true;
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }
}
