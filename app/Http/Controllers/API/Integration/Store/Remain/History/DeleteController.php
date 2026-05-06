<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;


class DeleteController extends BaseController
{
    public function __invoke(int $store_id, int $remain_id, int $history_id)
    {
        $this->service->delete($store_id, $remain_id, $history_id);
    }
}
