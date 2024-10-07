<?php

namespace Tests\Unit\Jobs;

use App\Jobs\MakeBoletoJob;
use App\Services\RemessaService;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class MakeBoletoJobTest extends TestCase
{

    public function testJobIsDispatched(): void
    {
        Queue::fake();
        MakeBoletoJob::dispatch();
        Queue::assertPushed(MakeBoletoJob::class);
    }

    public function testHandleJob(): void
    {
        $mockService = Mockery::mock(RemessaService::class);
        $mockService->shouldReceive('prepareMakeBoleto')->once();

        $this->app->instance(RemessaService::class, $mockService);

        $job = new MakeBoletoJob();
        $job->handle();
        $mockService->shouldHaveReceived('prepareMakeBoleto')->once();
    }
}
