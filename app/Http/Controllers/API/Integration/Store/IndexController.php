<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Store\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
