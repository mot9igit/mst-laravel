<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;


use App\Http\Requests\API\StoreRemain\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store, int $remain){
        $validated = $request->validated();
        return $this->service->update($remain, $validated);
    }
}
