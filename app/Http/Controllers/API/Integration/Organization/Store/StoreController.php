<?php

namespace App\Http\Controllers\API\Integration\Organization\Store;

use App\Http\Controllers\API\Integration\Organization\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Organization\Store\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->storeStore($validated);
    }
}
