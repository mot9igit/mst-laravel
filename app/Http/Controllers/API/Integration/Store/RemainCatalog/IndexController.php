<?php

namespace App\Http\Controllers\API\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreRemainCatalog\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        $validated['store_id'] = $request->route('store');
        return $this->service->get($validated);
    }
}
