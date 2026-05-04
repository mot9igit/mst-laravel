<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(int $storeId)
    {
        $store = Store::findOrFail($storeId)->with('city')->firstOrFail();
        return StoreResource::make($store);
    }
}
