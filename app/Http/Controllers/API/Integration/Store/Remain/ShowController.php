<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(int $remainId)
    {
        $remain = Store::findOrFail($remainId)->firstOrFail();
        return StoreResource::make($remain);
    }
}
