<?php

namespace App\Services;

use App\Repositories\RemessaRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class RemessaService extends BaseService
{
    protected $repository;

    public function __construct(RemessaRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($this->repository);
    }

    /**
     * @param UploadedFile $file
     * @return void
     */
    public function upload(UploadedFile $file) :void
    {
        $name = $file->getClientOriginalName();
        $path = "/remessa/" . $name;
        Storage::disk('local')->put($path, file_get_contents($file->getRealPath()));
    }

    /**
     * @param array $remessa
     * @return Model|null
     */
    public function saveRemessa(array $remessa): Model|null
    {
        try {
            $isRemessaExists = $this
                ->getRepository()
                ->getModel()
                ->where(['debtID' => $remessa['debtID']])
                ->exists();
            if (!$isRemessaExists) {
                return $this->getRepository()->save($remessa);
            }
            Log::info('remessa já existe no banco de dados' . $remessa['debtID']);
            return null;
        } catch (\Exception $exception) {
            Log::warning('Erro ao salvar remessa no database. ' . $exception->getMessage());
            return null;
        }
    }

    /**
     * @return void
     */
    public function prepareMakeBoleto(): void
    {
        $page = 0;
        do {
            $remessas = $this->repository->getAllBoletoNotMake($page);
            $this->makeBoleto($remessas->items());
            $page++;
        } while ($remessas->hasMorePages());
    }

    /**
     * @param array $remessas
     * @return bool
     */
    public function makeBoleto(array $remessas): bool
    {
        foreach ($remessas as $remessa) {
            try {
                Log::info('criando o boleto debtID: ' . $remessa->debtID);
                app()->make(MakeBoletoService::class)->makeBoleto($remessa);
                $remessa->isBoletoMaked = true;
                $remessa->update();
                Log::info('boleto criado e salvo debtID: ' . $remessa->debtID);
            } catch (\Exception $exception) {
                Log::warning('boleto não criado debtID: ' . $remessa->debtID);
                Log::warning($exception->getMessage());
            }
        }
        return true;
    }

    /**
     * @return void
     */
    public function prepareSendEmail(): void
    {
        $page = 0;
        do {
            $items = $this->repository->getAllEmailNotSendAndBoletoMaked($page);
            $this->sendEmail($items->items());
            $page++;
        } while ($items->hasMorePages());
    }

    /**
     * @param array $remessas
     * @return bool
     */
    public function sendEmail(array $remessas): bool
    {
        foreach ($remessas as $remessa) {
            try {
                app()->make(SendEmailService::class)->sendEmail($remessa);
                $remessa->isEmailSent = true;
                $remessa->update();
                Log::info('email enviado ' . $remessa->debtID);
            } catch (\Exception $exception) {
                Log::warning('email não enviado ' . $remessa->debtID);
            }
        }
        return true;
    }

    /**
     * @return bool|null
     */
    public function fileToDatabase(): bool|null
    {
        Log::info('Buscando arquivos..' . Carbon::now());
        $files = Storage::disk('local')->allFiles('/remessa');
        if (empty($files)) {
            Log::warning('Nenhuma remessa encontrada.');
            return null;
        }
        Log::info(count($files) . ' remessa(s) encontrada(s).');
        foreach ($files as $file) {
            try {
                $skip = 0;
                $storageFile = storage_path("app/" . $file);
                SimpleExcelReader::create($storageFile)
                    ->useDelimiter(',')
                    ->useHeaders(['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtID'])
                    ->getRows()
                    ->skip($skip)
                    ->take(100) //limite para teste local
                    ->each(
                        function ($row) use ($skip) {
                            $this->saveRemessa($row);
                            $skip += 1000;
                        }
                    );
            } catch (\Exception $exception) {
                Log::warning('Erro ao salvar arquivo ' . $file);
            }
        }
        Log::info('removendo remessas');
        foreach ($files as $file) {
            Storage::disk('local')->delete($file);
        }
        return true;
    }
}
