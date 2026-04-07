<?php

namespace App\Http\Controllers\API\Integration\BankRequisite;

use App\Http\Requests\API\BankRequisite\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        $response = $this->service->store($validated);
        return $response;
    }
}
