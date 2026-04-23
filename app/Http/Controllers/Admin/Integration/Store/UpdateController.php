<?php

namespace App\Http\Controllers\Admin\Integration\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(int $store_id)
    {
        $store = Store::findOrFail($store_id);
        return view('admin.integration.store.update', compact('store'));
    }
}
