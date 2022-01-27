<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kangaroo;

class KangarooController extends Controller
{
    /**
     * Return the index page.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $hasRecords = Kangaroo::count() >= 1;

        return view('index', compact('hasRecords'));
    }
    
    /**
     * Return the create page.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('create');
    }
    /**
     * Return the edit page.
     */
    public function edit(Kangaroo $kangaroo): \Illuminate\Contracts\View\View
    {
        return view('edit', compact('kangaroo'));
    }
}
