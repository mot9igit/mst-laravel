<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteController extends BaseController
{
    public function __invoke(int $store_id)
    {
        $this->service->delete($store_id);
    }
}
