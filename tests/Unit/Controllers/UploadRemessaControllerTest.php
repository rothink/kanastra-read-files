<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\RemessaController;
use App\Http\Requests\CreateUploadFormRequest;
use App\Services\RemessaService;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class UploadRemessaControllerTest extends TestCase
{

    /**
     * @group upload
     */
    public function testUploadRemessa(): void
    {
        $this->partialMock(RemessaService::class, function ($mock) {
            $mock->shouldReceive('upload')->andReturn(true);
        });

        $controller = app()->make(RemessaController::class);

        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('input.csv', json_encode($this->makeParams()));

        $request = new CreateUploadFormRequest();
        $request->setMethod('POST');
        $request->headers->set('Content-Type', 'multipart/form-data');
        $request->files->set('input', $fileUploadRemessa);

        $response = $controller->upload($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->status());
    }

    /**
     * @group upload-exception
     */
    public function testUploadRemessaException(): void
    {
        // Mock do serviço que você deseja mockar (exemplo)
        $this->partialMock(RemessaService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('upload')
                ->andThrow(\Exception::class);
        });

        $controller = app()->make(RemessaController::class);

        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('input.csv', json_encode($this->makeParams()));

        $request = new CreateUploadFormRequest();
        $request->setMethod('POST');
        $request->headers->set('Content-Type', 'multipart/form-data');
        $request->files->set('input', $fileUploadRemessa);

        $response = $controller->upload($request);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->status());
    }
}
