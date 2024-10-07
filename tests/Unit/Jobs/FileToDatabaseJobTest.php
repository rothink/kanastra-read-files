<?php

namespace Tests\Unit\Jobs;

use App\Jobs\FileToDatabaseJob;
use App\Services\RemessaService;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Tests\TestCase;

class FileToDatabaseJobTest extends TestCase
{
    public function testJobIsDispatched(): void
    {
        Queue::fake();
        FileToDatabaseJob::dispatch();
        Queue::assertPushed(FileToDatabaseJob::class);
    }

    public function testHandleJob(): void
    {
        $mockService = Mockery::mock(RemessaService::class);
        $mockService->shouldReceive('fileToDatabase')->once();

        $this->app->instance(RemessaService::class, $mockService);

        $job = new FileToDatabaseJob();
        $job->handle();
        $mockService->shouldHaveReceived('fileToDatabase')->once();
    }
}
