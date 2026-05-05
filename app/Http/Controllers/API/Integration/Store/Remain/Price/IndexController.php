<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\Price;

use App\Http\Requests\API\StoreRemainPrice\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        $validated['store_id'] = $request->store;
        $validated['remain_id'] = $request->remain;
        return $this->service->get($validated);
    }
}
