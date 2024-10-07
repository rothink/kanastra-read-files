<?php

namespace App\Services;

use App\Interfaces\RepositoryInterface;
use App\Interfaces\ServiceInterface;

abstract class BaseService implements ServiceInterface
{
    /**
     *
     * @var RepositoryInterface
     */
    protected $repository;


    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }
}
