<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUploadFormRequest;
use App\Services\RemessaService;
use Illuminate\Http\JsonResponse;
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

    public function upload(CreateUploadFormRequest $request): JsonResponse
    {
        try {
            $this->service->upload($request->file('input'));
            return \response()->json([], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return \response()->json(['error' => 'Erro ao fazer upload'], Response::HTTP_BAD_REQUEST);
        }
    }
}
