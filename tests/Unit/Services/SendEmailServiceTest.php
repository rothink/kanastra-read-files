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

class SendEmailServiceTest extends TestCase
{

    /**
     * @group send-email-in-service
     */
    public function testMakeBoleto(): void
    {
        $params = $this->makeParams();

        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('boleto-maked/' . $params['debtID'], json_encode($this->makeParams()));

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('get')
            ->withAnyArgs()
            ->andReturn($fileUploadRemessa);

        Storage::shouldReceive('delete')
            ->withAnyArgs()
            ->andReturnTrue();

        $service = app()->make(SendEmailService::class);

        $response = $service->sendEmail(new Remessa($params));
        $this->assertTrue($response);
    }

    /**
     * @group send-email-in-service-exception
     */
    public function testMakeBoletoException(): void
    {
        $params = $this->makeParams();

        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('boleto-maked/' . $params['debtID'], json_encode($this->makeParams()));

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('get')
            ->withAnyArgs()
            ->andReturn($fileUploadRemessa);

        Storage::shouldReceive('delete')
            ->withAnyArgs()
            ->andThrow(\Exception::class);

        $service = app()->make(SendEmailService::class);

        $response = $service->sendEmail(new Remessa($params));
        $this->assertFalse($response);


    }
}
