<?php

namespace App\Filters;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    /**
     * Query builder instance.
     * 
     * @var Builder
     */
    protected $builder;

    /**
     * Request instance.
     * 
     * @var Request
     */
    private $request;

    /**
     * Create filter instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters.
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        collect($this->request->filter)->each(function ($items, $key) {
            $method = Str::camel(trim($key));

            // skip if method doesn't exist
            if (! method_exists($this, $method)) {
                return true;
            }

            try {
                call_user_func_array(
                    [$this, $method],
                    array_filter([$items], function ($searchTerm) {
                        return strlen(trim($searchTerm)) >= 1;
                    })
                );
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        });

        return $this->builder;
    }

    /**
     * Convert string to array using a separator.
     */
    protected function explodeValue(string $value): array
    {
        return collect(explode(',', $value))->map(function ($item) {
            return trim($item);
        })
            ->toArray();
    }
}
