<?php

namespace Tests\Unit\Services;

use App\Models\Remessa;
use App\Services\MakeBoletoService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MakeBoletoServiceTest extends TestCase
{

    /**
     * @group make-boleto-in-service
     */
    public function testMakeBoleto(): void
    {
        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('fake-boleto-in-test.pdf', json_encode($this->makeParams()));

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('get')
            ->withAnyArgs()
            ->andReturn($fileUploadRemessa);

        Storage::shouldReceive('put')
            ->withAnyArgs()
            ->andReturnTrue();

        $service = app()->make(MakeBoletoService::class);

        $response = $service->makeBoleto(new Remessa($this->makeParams()));

        $this->assertEquals(true, $response);
    }

    /**
     * @group make-boleto-in-service-exception
     */
    public function testMakeBoletoException(): void
    {
        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('fake-boleto-in-test.pdf', json_encode($this->makeParams()));

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('get')
            ->withAnyArgs()
            ->andReturn($fileUploadRemessa);

        Storage::shouldReceive('put')
            ->withAnyArgs()
            ->andThrow(\Exception::class);

        $service = app()->make(MakeBoletoService::class);

        $response = $service->makeBoleto(new Remessa($this->makeParams()));
        $this->assertEquals(false, $response);
    }
}
