<?php

namespace App\Http\Controllers\API\Integration\Organization\Store;

use App\Http\Controllers\API\Integration\Organization\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Organization\Store\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->getStores($validated);
    }
}
