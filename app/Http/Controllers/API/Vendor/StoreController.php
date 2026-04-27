<?php

namespace App\Http\Controllers\API\Vendor;


use App\Http\Requests\API\Vendor\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
