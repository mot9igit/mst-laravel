<?php

namespace App\Http\Controllers\API\Integration\Store\Doc;

use App\Http\Controllers\API\Integration\Store\BaseController;
use App\Http\Requests\API\StoreDoc\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        try {
            $validated = $request->validated();
            return $this->service->store($validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при создании документа',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
