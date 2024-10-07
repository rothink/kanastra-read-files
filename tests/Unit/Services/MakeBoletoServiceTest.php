<?php

namespace Tests\Unit\Services;

use App\Http\Controllers\RemessaController;
use App\Http\Requests\CreateUploadFormRequest;
use App\Models\Remessa;
use App\Repositories\RemessaRepository;
use App\Services\MakeBoletoService;
use App\Services\RemessaService;
use App\Services\SendEmailService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;
use Mockery;

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
