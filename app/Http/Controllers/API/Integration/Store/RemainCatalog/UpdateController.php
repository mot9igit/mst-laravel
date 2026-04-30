<?php

namespace App\Http\Controllers\API\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreRemainCatalog\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store, int $catalog){
        $validated = $request->validated();
        return $this->service->update($store, $catalog, $validated);
    }
}
