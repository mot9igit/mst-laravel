<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;

use App\Http\Requests\API\StoreRemainHistory\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store, int $remain, int $history){
        $validated = $request->validated();
        $store_id = $request->store;
        $remain_id = $request->remain;
        return $this->service->update($store_id, $remain_id, $history, $validated);
    }
}
