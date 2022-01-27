<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreKangarooRequest;
use App\Http\Requests\UpdateKangarooRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Kangaroo;
use Illuminate\Http\Request;
use App\Filters\KangarooFilter;

class KangarooController extends Controller
{
    /**
     * List all kangaroos.
     */
    public function index(Request $request, KangarooFilter $filter): \Illuminate\Http\JsonResponse
    {
        return (new ResourceCollection(
            Kangaroo::filter($filter)
                ->sort($request->sort)
                ->when($request->per_page == 'max', function ($query) {
                    return $query->get();
                })
                ->when($request->per_page != 'max', function ($query) use ($request) {
                    return $query->paginate((int) $request->per_page);
                })
        ))
            ->response();
    }

    /**
     * Create a new kangaroo record.
     */
    public function store(StoreKangarooRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        return (new Resource(Kangaroo::create($validated)))
            ->response();
    }

    /**
     * Get specific kangaroo.
     */
    public function show(Kangaroo $kangaroo): \Illuminate\Http\JsonResponse
    {
        return (new Resource($kangaroo))
            ->response();
    }

    /**
     * Update specific kangaroo.
     */
    public function update(UpdateKangarooRequest $request, Kangaroo $kangaroo): \Illuminate\Http\JsonResponse
    {
        $kangaroo->update($request->validated());

        return (new Resource($kangaroo))
            ->response();
    }
}
