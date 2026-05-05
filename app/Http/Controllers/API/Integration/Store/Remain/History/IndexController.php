<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;

use App\Http\Requests\API\StoreRemainHistory\IndexRequest;

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
