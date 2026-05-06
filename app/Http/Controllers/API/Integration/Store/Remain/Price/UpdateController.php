<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\Price;

use App\Http\Requests\API\StoreRemainPrice\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store, int $remain, int $price){
        $validated = $request->validated();
        $store_id = $request->store;
        $remain_id = $request->remain;
        return $this->service->update($store_id, $remain_id, $price, $validated);
    }
}
