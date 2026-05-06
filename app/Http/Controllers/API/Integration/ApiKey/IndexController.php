<?php

namespace App\Http\Controllers\API\Integration\ApiKey;


use App\Http\Requests\API\ApiKey\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
