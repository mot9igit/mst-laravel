<?php

namespace App\Http\Controllers\API\Integration\Requisite;
use App\Http\Requests\API\Requisite\IndexRequest;

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
