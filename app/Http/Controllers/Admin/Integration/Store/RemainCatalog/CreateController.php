<?php

namespace App\Http\Controllers\Admin\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('admin.integration.store.remain-catalog.create');
    }
}
