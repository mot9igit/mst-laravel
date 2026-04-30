<?php

namespace App\Http\Controllers\API\Integration\Store\RemainCatalog;

use App\Models\StoreRemainCatalog;

class ShowController extends BaseController
{
    public function __invoke($storeId, $catalogId)
    {
        $catalog = StoreRemainCatalog::findOrFail($catalogId)->firstOrFail();
        return $catalog;
    }
}
