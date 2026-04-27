<?php

namespace App\Http\Controllers\API\Integration\Organization\Vendor;

use App\Http\Controllers\API\Integration\Organization\BaseController;
use App\Http\Requests\API\Organization\Vendor\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->storeVendor($validated);
        return $response;
    }
}
