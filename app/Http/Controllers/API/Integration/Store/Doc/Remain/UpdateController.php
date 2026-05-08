<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use App\Http\Requests\API\StoreDocRemain\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            return $this->service->update($id, $validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при обновлении документа',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
