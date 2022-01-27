<?php

namespace App\Filters;

use Illuminate\Support\Carbon;

class KangarooFilter extends AbstractFilter
{
    /**
     * Filter by name.
     */
    public function name(string $value): void
    {
        $this->builder->where('name', 'like', "%{$value}%");
    }

    /**
     * Add a "from" range filter to birthday. 
     */
    public function fromBirthday(string $value): void
    {
        $this->builder->whereDate(
            'birthday', 
            '>=', 
            Carbon::parse($value)->format('Y-m-d')
        );
    }

    /**
     * Add a "to" range filter to birthday. 
     */
    public function toBirthday(string $value): void
    {
        $this->builder->whereDate(
            'birthday', 
            '<=', 
            Carbon::parse($value)->format('Y-m-d')
        );
    }

    /**
     *  Filter by friendliness. 
     */
    public function friendliness(string $value): void
    {
        $this->builder->whereIn('friendliness', $this->explodeValue($value));
    }
}
