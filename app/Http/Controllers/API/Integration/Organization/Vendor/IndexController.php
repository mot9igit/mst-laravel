<?php

namespace App\Http\Controllers\API\Integration\Organization\Vendor;

use App\Http\Controllers\API\Integration\Organization\BaseController;
use App\Http\Requests\API\Organization\Vendor\IndexRequest;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->getVendors($validated);
    }
}
