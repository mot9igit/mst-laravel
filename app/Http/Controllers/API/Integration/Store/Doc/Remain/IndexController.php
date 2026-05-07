<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use App\Http\Requests\API\StoreDoc\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
