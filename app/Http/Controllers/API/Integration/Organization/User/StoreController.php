<?php

namespace App\Http\Controllers\API\Integration\Organization\User;

use App\Http\Controllers\API\Integration\Organization\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Organization\User\StoreRequest;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->storeUser($validated);
        return $response;
    }
}
