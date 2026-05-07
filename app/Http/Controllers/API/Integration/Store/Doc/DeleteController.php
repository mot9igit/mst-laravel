<?php

namespace App\Http\Controllers\API\Integration\Store\Doc;

use App\Http\Controllers\API\Integration\Store\BaseController;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    public function __invoke(Request $request, string $store_id, int $doc_id)
    {
        try {
            $this->service->delete($store_id, $doc_id);

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
