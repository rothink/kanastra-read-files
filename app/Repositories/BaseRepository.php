<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->getModel()->forceCreate($this->formatParams($params));
    }

    /**
     * @param array $params
     * @param string $value
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute(array $params, string $value, $default = null): mixed
    {
        return (isset($params[$value])) ? $params[$value] : $default;
    }
}
