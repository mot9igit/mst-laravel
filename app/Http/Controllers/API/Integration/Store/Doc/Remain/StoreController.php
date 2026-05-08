<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use App\Http\Requests\API\StoreDocRemain\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            return $this->service->store($validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при создании номенклатуры документа',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
