<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Models\StoreRemain;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(string $storeId, int $remainId)
    {
        $remain = StoreRemain::findOrFail($remainId)->with(['store', 'parent', 'category', 'vendor'])->firstOrFail();
        return $remain;
    }
}
