<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\Price;

use App\Models\StoreRemainPrice;

class ShowController extends BaseController
{
    public function __invoke(string $storeId, int $remainId, int $priceId)
    {
        $remainPrice = StoreRemainPrice::findOrFail($priceId)->firstOrFail();
        return $remainPrice;
    }
}
