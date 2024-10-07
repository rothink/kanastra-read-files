<?php

namespace Tests\Unit\Services;

use App\Models\Remessa;
use App\Repositories\RemessaRepository;
use App\Services\MakeBoletoService;
use App\Services\RemessaService;
use App\Services\SendEmailService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

class RemessaServiceTest extends TestCase
{

    /**
     * @group make-boleto
     */
    public function testMakeBoleto(): void
    {
        $this->partialMock(MakeBoletoService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('makeBoleto')
                ->andReturn(true);
        });

        $service = app()->make(RemessaService::class);

        $remassa1 = new Remessa($this->makeParams());
        $remassa2 = new Remessa($this->makeParams());

        $response = $service->makeBoleto([$remassa1, $remassa2]);
        $this->assertEquals($response, true);
    }

    /**
     * @group make-boleto-exception
     */
    public function testMakeBoletoException(): void
    {
        $this->partialMock(MakeBoletoService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('makeBoleto')
                ->andThrow(\Exception::class);
        });

        Log::shouldReceive('warning')
            ->withAnyArgs();

        $service = app()->make(RemessaService::class);

        $remassa1 = new Remessa($this->makeParams());
        $remassa2 = new Remessa($this->makeParams());

        $response = $service->makeBoleto([$remassa1, $remassa2]);
        $this->assertTrue($response);
    }

    /**
     * @group send-email
     */
    public function testSendEmail(): void
    {
        $this->partialMock(SendEmailService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('sendEmail')
                ->andReturn(true);
        });

        $service = app()->make(RemessaService::class);

        $remassa1 = new Remessa($this->makeParams());

        $response = $service->sendEmail([$remassa1]);
        $this->assertEquals($response, true);
    }

    /**
     * @group send-email-exception
     */
    public function testSendEmailException(): void
    {
        $this->partialMock(SendEmailService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('sendEmail')
                ->andThrow(\Exception::class);
        });

        Log::shouldReceive('warning')
            ->times(1)
            ->withAnyArgs();

        $service = app()->make(RemessaService::class);

        $remassa1 = new Remessa($this->makeParams());

        $service->sendEmail([$remassa1]);
    }

    /**
     * @group prepare-send-email
     */
    public function testPrepareSendEmail(): void
    {
        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getAllEmailNotSendAndBoletoMaked')
                ->andReturn(
                    new LengthAwarePaginator([], 1, 10)
                );
        });
        $service = app()->make(RemessaService::class);
        $items = $service->prepareSendEmail();
        $this->assertNull($items);
    }

    /**
     * @group prepare-send-email
     */
    public function testPrepareMakeBoleto(): void
    {
        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getAllBoletoNotMake')
                ->andReturn(
                    new LengthAwarePaginator([], 1, 10)
                );
        });
        $service = app()->make(RemessaService::class);
        $items = $service->prepareMakeBoleto();
        $this->assertNull($items);
    }

    /**
     * @group save-remessa-already-exists
     */
    public function testSaveRemessaAlreadyExists(): void
    {
        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturn(true);
        });
        $service = app()->make(RemessaService::class);
        $items = $service->saveRemessa($this->makeParams());
        $this->assertNull($items);
    }

    /**
     * @group save-remessa-not-exists
     */
    public function testSaveRemessaNotExists(): void
    {

        $params = $this->makeParams();

        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) use ($params) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturnFalse();

            $mock
                ->shouldReceive('save')
                ->with($params)
                ->andReturn(new Remessa($params));
        });
        $service = app()->make(RemessaService::class);
        $item = $service->saveRemessa($params);
        $this->assertInstanceOf(Remessa::class, $item);
        $this->assertEquals($params['name'], $item->name);
        $this->assertEquals($params['governmentId'], $item->governmentId);
        $this->assertEquals($params['email'], $item->email);
        $this->assertEquals($params['debtAmount'], $item->debtAmount);
        $this->assertEquals($params['debtDueDate'], $item->debtDueDate);
        $this->assertEquals($params['debtID'], $item->debtID);
    }

    /**
     * @group save-remessa-not-exists-exception
     */
    public function testSaveRemessaNotExistsException(): void
    {
        $params = $this->makeParams();

        Log::shouldReceive('warning')
            ->times(1)
            ->withAnyArgs();

        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) use ($params) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturnFalse();

            $mock
                ->shouldReceive('save')
                ->with($params)
                ->andThrow(\Exception::class);
        });
        $service = app()->make(RemessaService::class);
        $item = $service->saveRemessa($params);

        $this->assertNull($item);
    }

    /**
     * @group file-to-database
     */
    public function testfileToDatabase(): void
    {
        $params = $this->makeParams();

        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) use ($params) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturnFalse();

            $mock
                ->shouldReceive('save')
                ->with($params)
                ->andReturn(new Remessa($params));
        });

        $fakeCsv = Storage::disk('local')->files('/csv-fake');

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('allFiles')
            ->andReturn(['/' . $fakeCsv[0]]);

        Storage::shouldReceive('delete')
            ->andReturnTrue();

        $service = app()->make(RemessaService::class);
        $response = $service->fileToDatabase();
        $this->assertTrue($response);
    }
    /**
     * @group file-to-database-exception-when-save
     */
    public function testFileToDatabaseExceptionWhenSave(): void
    {
        $params = $this->makeParams();

        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) use ($params) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturnFalse();

            $mock
                ->shouldReceive('save')
                ->with($params)
                ->andThrow(\Exception::class);
        });

        $fakeCsv = Storage::disk('local')->files('/csv-fake');

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('allFiles')
            ->andReturn(['/' . $fakeCsv[0]]);

        Storage::shouldReceive('delete')
            ->andReturnTrue();

        Log::shouldReceive('info')
        ->withAnyArgs();

        Log::shouldReceive('warning')
        ->with('Erro ao salvar arquivo /csv-fake/input-file-test.csv');

        $service = app()->make(RemessaService::class);
        $response = $service->fileToDatabase();
        $this->assertTrue($response);
    }

    /**
     * @group no-files
     */
    public function testFileToDatabaseWithNoFilesToRead(): void
    {

        $params = $this->makeParams();

        $this->partialMock(RemessaRepository::class, function (MockInterface $mock) use ($params) {
            $mock
                ->shouldReceive('getModel')
                ->andReturnSelf();

            $mock
                ->shouldReceive('where')
                ->withAnyArgs()
                ->andReturnSelf();

            $mock
                ->shouldReceive('exists')
                ->andReturnFalse();

            $mock
                ->shouldReceive('save')
                ->with($params)
                ->andReturn(new Remessa($params));
        });

        Storage::shouldReceive('disk')
            ->andReturnSelf();

        Storage::shouldReceive('allFiles')
            ->andReturn('');

        Log::shouldReceive('info')
            ->withAnyArgs();

        Log::shouldReceive('warning')
            ->with('Nenhuma remessa encontrada.');

        $service = app()->make(RemessaService::class);
        $response = $service->fileToDatabase();
        $this->assertNull($response);
    }

}
