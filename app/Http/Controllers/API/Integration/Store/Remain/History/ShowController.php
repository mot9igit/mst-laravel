<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;

use App\Models\StoreRemainHistory;

class ShowController extends BaseController
{
    public function __invoke(string $storeId, int $remainId, int $historyId)
    {
        $remainHistory = StoreRemainHistory::findOrFail($historyId)->firstOrFail();
        return $remainHistory;
    }
}
