<?php

namespace App\Http\Controllers\API\Vendor;

class DeleteController extends BaseController
{
    public function __invoke(int $vendor_id)
    {
        $this->service->delete($vendor_id);
    }
}
