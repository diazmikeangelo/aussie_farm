<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\FilterableTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Kangaroo extends Model
{
    use FilterableTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Query scope for sorting.
     */
    public function scopeSort(Builder $query, ?string $fields = null): Builder
    {
        $fields = collect(explode(',', $fields));

        $fields->filter()->each(function ($field) use ($query) {
            $order = Str::startsWith($field, '-') ? 'desc' : 'asc';

            // normalize field name if starts with '-'
            $field = Str::replaceFirst('-', '', $field);

            $query->orderBy($field, $order);
        });

        return $query;
    }

    /**
     * Set the height value to two decimal places.
     */
    public function setHeightAttribute(float $value): void
    {
        $this->attributes['height'] = bcdiv((string) $value, '1', 2);
    }

    /**
     * Set the weight value to two decimal places.
     */
    public function setWeightAttribute(float $value): void
    {
        $this->attributes['weight'] = bcdiv((string) $value, '1', 2);
    }
}
