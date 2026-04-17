<?php

namespace App\Http\Controllers\API\System\Geo\Country;

use App\Http\Requests\API\Geo\Country\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
