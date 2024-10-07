<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUploadFormRequest;
use App\Services\RemessaService;
use Illuminate\Http\Response;

class RemessaController extends Controller
{
    /**
     * @var RemessaService
     */
    public function __construct(RemessaService $service)
    {
        $this->service = $service;
    }

    public function upload(CreateUploadFormRequest $request)
    {
        try {
            $this->service->upload($request->file('input'));
            return \response()->json([], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return \response()->json(['error' => 'Erro ao fazer upload'], Response::HTTP_BAD_REQUEST);;
        }
    }

//    public function jobSaveDatabase()
//    {
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
//    }

//    public function jobMakeBoleto()
//    {
//        $this->service->prepareMakeBoleto();
//    }
//    public function jobSendEmail()
//    {
//        $this->service->prepareSendEmail();
//    }
}
