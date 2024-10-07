<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface ModelInterface
{
	public function scopeQuery(Builder $queryBuilder, $params = []);
}
