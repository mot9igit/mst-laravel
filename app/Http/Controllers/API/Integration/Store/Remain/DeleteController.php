<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;


class DeleteController extends BaseController
{
    public function __invoke(int $store_id, int $remain_id)
    {
        $this->service->delete($remain_id);
    }
}
