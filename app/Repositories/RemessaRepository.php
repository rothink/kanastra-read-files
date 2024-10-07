<?php

namespace App\Repositories;

use App\Models\Remessa;

class RemessaRepository extends BaseRepository
{

    public $model;

    public function __construct(Remessa $model)
    {
        $this->model = $model;
    }

    public function formatParams(array $params): array
    {
        return [
            'name' => $this->getAttribute($params, 'name'),
            'governmentId' => $this->getAttribute($params, 'governmentId'),
            'email' => $this->getAttribute($params, 'email'),
            'debtAmount' => $this->getAttribute($params, 'debtAmount'),
            'debtDueDate' => $this->getAttribute($params, 'debtDueDate'),
            'debtID' => $this->getAttribute($params, 'debtID'),
            'isBoletoMaked' => $this->getAttribute($params, 'isBoletoMaked', false),
            'isEmailSent' => $this->getAttribute($params, 'isEmailSent', false),
        ];
    }

    public function getAllBoletoNotMake()
    {
        return $this
            ->model
            ->where(['isBoletoMaked' => false])
            ->paginate(100)
            ->withQueryString();

    }

    public function getAllEmailNotSendAndBoletoMaked()
    {
        return $this
            ->model
            ->where(['isEmailSent' => false, 'isBoletoMaked' => true])
            ->paginate(100)
            ->withQueryString();
    }

}
