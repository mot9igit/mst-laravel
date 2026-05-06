<?php

namespace App\Http\Controllers\API\Integration\ApiKey;

use App\Http\Requests\API\ApiKey\StoreRequest;
use Illuminate\Support\Facades\Log;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();
        return $this->service->store($validated);
    }
}
