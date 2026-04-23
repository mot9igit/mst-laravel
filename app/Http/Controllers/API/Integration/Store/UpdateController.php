<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Store\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store){
        $validated = $request->validated();
        return $this->service->update($store, $validated);
    }
}
