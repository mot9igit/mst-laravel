<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\Price;


class DeleteController extends BaseController
{
    public function __invoke(int $store_id, int $remain_id, int $price_id)
    {
        $this->service->delete($store_id, $remain_id, $price_id);
    }
}
