<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreRemain\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->store($validated);
    }
}
