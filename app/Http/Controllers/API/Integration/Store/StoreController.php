<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Store\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->store($validated);
    }
}
