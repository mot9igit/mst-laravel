<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    public function __invoke(int $store_id, $remain_id)
    {
        try {
            $this->service->delete($store_id, $remain_id);

            return response()->json([
                'message' => 'Документ успешно удален',
                'success' => true,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при удалении документа',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
