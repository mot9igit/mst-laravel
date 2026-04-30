<?php

namespace App\Http\Controllers\API\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    public function __invoke(int $store_id, int $catalog_id)
    {
        $this->service->delete($store_id, $catalog_id);
    }
}
