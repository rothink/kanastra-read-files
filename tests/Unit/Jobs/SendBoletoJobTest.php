<?php

namespace Tests\Unit\Jobs;

use App\Jobs\SendEmailJob;
use App\Services\RemessaService;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class SendBoletoJobTest extends TestCase
{

    public function testJobIsDispatched(): void
    {
        Queue::fake();
        SendEmailJob::dispatch();
        Queue::assertPushed(SendEmailJob::class);
    }
    public function testHandleJob(): void
    {
        $mockService = Mockery::mock(RemessaService::class);
        $mockService->shouldReceive('prepareSendEmail')->once();

        $this->app->instance(RemessaService::class, $mockService);

        $job = new SendEmailJob();
        $job->handle();
        $mockService->shouldHaveReceived('prepareSendEmail')->once();
    }
}
