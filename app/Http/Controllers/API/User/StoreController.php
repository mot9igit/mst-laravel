<?php

namespace App\Http\Controllers\API\User;
use App\Http\Requests\API\User\StoreRequest;

class StoreController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request)
    {
        $response = $this->service->store($request);
        return $response;
    }
}
