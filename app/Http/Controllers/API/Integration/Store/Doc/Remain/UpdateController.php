<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use App\Http\Requests\API\StoreDocRemain\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, string $store_id, string $doc_id)
    {
        try {
            $validated = $request->validated();
            return $this->service->update($store_id, $doc_id, $validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при обновлении документа',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
