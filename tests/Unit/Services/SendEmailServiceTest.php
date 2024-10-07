<?php

namespace Tests\Unit\Services;

use App\Models\Remessa;
use App\Services\SendEmailService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SendEmailServiceTest extends TestCase
{

    /**
     * @group send-email-in-service
     */
    public function testSendEmail(): void
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

    public function testSendEmailWithNoFile(): void
    {
        $params = $this->makeParams();

        $fileUploadRemessa = UploadedFile::fake()
            ->createWithContent('boleto-maked/' . $params['debtID'], json_encode($this->makeParams()));

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('get')
            ->withAnyArgs()
            ->andReturn([]);

        $service = app()->make(SendEmailService::class);

        $response = $service->sendEmail(new Remessa($params));
        $this->assertFalse($response);
    }

    /**
     * @group send-email-in-service-exception
     */
    public function testSendEmailException(): void
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
