<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterableTrait
{
    /**
     * Scope a query to filter base on request queries.
     */
    public function scopeFilter(Builder $query, AbstractFilter $filter): Builder
    {
        return $filter->apply($query);
    }
}
