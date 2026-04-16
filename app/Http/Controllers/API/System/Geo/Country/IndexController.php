<?php

namespace App\Http\Controllers\API\System\Geo\Country;

use App\Http\Requests\API\Geo\Country\IndexRequest;

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
