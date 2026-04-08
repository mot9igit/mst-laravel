<?php

namespace App\Http\Controllers\API\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ProductCategory\IndexRequest;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->getAll($validated);
    }
}
