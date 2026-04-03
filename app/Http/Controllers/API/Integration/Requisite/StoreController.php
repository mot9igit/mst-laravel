<?php

namespace App\Http\Controllers\API\Integration\Requisite;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Requisite\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
