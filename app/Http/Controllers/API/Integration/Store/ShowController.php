<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(int $cityId)
    {
        $store = Store::findOrFail($cityId)->with('city')->firstOrFail();
        return StoreResource::make($store);
    }
}
