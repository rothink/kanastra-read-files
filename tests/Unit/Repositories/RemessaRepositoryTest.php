<?php

namespace Tests\Unit\Repositories;

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

class RemessaRepositoryTest extends TestCase
{

    /**
     * @group format-params
     */
    public function testFormatParams(): void
    {
        $repo = app()->make(RemessaRepository::class);
        $response = $repo->formatParams($this->makeParams());

        $this->assertIsArray($response);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('governmentId', $response);
        $this->assertArrayHasKey('email', $response);
        $this->assertArrayHasKey('debtAmount', $response);
        $this->assertArrayHasKey('debtDueDate', $response);
        $this->assertArrayHasKey('debtID', $response);
    }

    /**
     * @group queryGetAllEmailNotSendAndBoletoMaked
     */
    public function testQueryGetAllEmailNotSendAndBoletoMaked(): void
    {
        $this->partialMock(Remessa::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('model')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('paginate')
                ->andReturnSelf();

            $mock
                ->shouldReceive('withQueryString')
                ->withAnyArgs()
                ->andReturn(
                    new LengthAwarePaginator([], 1, 10)
                );
        });

        $repo = app()->make(RemessaRepository::class);
        $items = $repo->getAllEmailNotSendAndBoletoMaked();

        $this->assertInstanceOf(LengthAwarePaginator::class, $items);
    }

    /**
     * @group querygetAllBoletoNotMake
     */
    public function testQuerygetAllBoletoNotMake(): void
    {
        $this->partialMock(Remessa::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('model')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('paginate')
                ->andReturnSelf();

            $mock
                ->shouldReceive('withQueryString')
                ->withAnyArgs()
                ->andReturn(
                    new LengthAwarePaginator([], 1, 10)
                );
        });

        $repo = app()->make(RemessaRepository::class);
        $items = $repo->getAllBoletoNotMake();

        $this->assertInstanceOf(LengthAwarePaginator::class, $items);
    }

    /**
     * @group get-model
     */
    public function testGetModelRepostiory(): void
    {
        $repository = app()->make(RemessaRepository::class);
        $model = $repository->getModel();
        $this->assertInstanceOf(Remessa::class, $model);
    }
}
