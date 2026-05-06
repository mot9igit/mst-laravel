<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;

use App\Http\Requests\API\StoreRemainHistory\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->store($validated);
    }
}
