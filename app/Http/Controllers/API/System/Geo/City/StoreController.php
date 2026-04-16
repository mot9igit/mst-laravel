<?php

namespace App\Http\Controllers\API\System\Geo\City;

use App\Http\Requests\API\Geo\City\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
