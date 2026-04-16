<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Http\Requests\API\Geo\Region\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
