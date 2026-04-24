<?php

namespace App\Http\Controllers\API\Integration\Organization\Store;

use App\Http\Controllers\API\Integration\Organization\BaseController;

class DeleteController extends BaseController
{
    public function __invoke(int $organization, int $store)
    {
        $this->service->deleteStore($organization, $store);
    }
}
