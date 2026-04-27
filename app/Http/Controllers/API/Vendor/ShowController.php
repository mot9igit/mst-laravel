<?php

namespace App\Http\Controllers\API\Vendor;

use App\Models\Vendor;

class ShowController extends BaseController
{
    public function __invoke(int $vendorId)
    {
        return Vendor::findOrFail($vendorId)->firstOrFail();
    }
}
