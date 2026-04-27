<?php

namespace App\Http\Controllers\API\Integration\Organization\Vendor;

use App\Http\Controllers\API\Integration\Organization\BaseController;

class DeleteController extends BaseController
{
    public function __invoke(int $organization, int $vendor)
    {
        $this->service->deleteVendor($organization, $vendor);
    }
}
