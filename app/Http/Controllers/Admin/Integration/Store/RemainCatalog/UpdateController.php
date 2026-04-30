<?php

namespace App\Http\Controllers\Admin\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreRemain;
use App\Models\StoreRemainCatalog;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(int $catalog_id)
    {
        $catalog = StoreRemainCatalog::findOrFail($catalog_id);
        return view('admin.integration.store.remain-catalog.update', compact('catalog'));
    }
}
