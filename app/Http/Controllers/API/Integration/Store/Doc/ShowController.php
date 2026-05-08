<?php

namespace App\Http\Controllers\API\Integration\Store\Doc;

use App\Http\Controllers\API\Integration\Store\BaseController;

class ShowController extends BaseController
{
    public function __invoke(int $storeId, int $doc_id)
    {
        return $this->service->findOne($storeId);
    }
}
