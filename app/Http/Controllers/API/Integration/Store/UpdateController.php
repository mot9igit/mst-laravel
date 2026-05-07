<?php


namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Requests\API\Store\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $store)
    {
        $validated = $request->validated();
        return $this->service->update($store, $validated);
    }
}
