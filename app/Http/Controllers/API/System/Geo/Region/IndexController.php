<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Http\Requests\API\Geo\Region\IndexRequest;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
