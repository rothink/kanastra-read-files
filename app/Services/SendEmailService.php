<?php

namespace App\Services;

use App\Models\Remessa;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SendEmailService
{
    public function sendEmail(Remessa $remessa): bool|null
    {
        $file = Storage::disk('local')->get('/boleto-maked/' . $remessa->debtID . '.pdf');
        if ($file) {
            try {
                $response = Http::get('https://run.mocky.io/v3/99dcb239-79b9-4719-9c27-f38add127b21');
                if ($response->status() == Response::HTTP_CREATED) {
                    Log::info('e-mail enviado para: ' . $remessa->debtID);
                    $file = Storage::disk('local')->delete('/boleto-maked/' . $remessa->debtID . '.pdf');
                    return true;
                }
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
                return false;
            }
        }
        return false;
    }
}
