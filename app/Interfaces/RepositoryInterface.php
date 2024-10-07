<?php

namespace App\Interfaces;
interface RepositoryInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function formatParams(array $params) :array;
}
