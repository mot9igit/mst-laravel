<?php

namespace App\Http\Controllers\API\Integration\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Organization\IndexRequest;
use Illuminate\Http\Request;

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
