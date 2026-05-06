<?php

namespace App\Http\Controllers\API\RequestLog;


use App\Http\Requests\API\RequestLog\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
