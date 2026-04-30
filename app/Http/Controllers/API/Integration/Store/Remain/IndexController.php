<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreRemain\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
