<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model implements ModelInterface
{
    protected $appends = [
        'created_at_to_human',
        'created_at_formated',
    ];

    /**
     * @return string
     */
    public function getCreatedAtToHumanAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }

    /**
     * @return string
     */
    public function getCreatedAtFormatedAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->format('d/m/Y');
    }

    /**
     * @param Builder $queryBuilder
     * @param array $params
     * @return Builder
     */
    public function scopeQuery(Builder $queryBuilder, $params = []): Builder
    {
        return $queryBuilder;
    }
}
