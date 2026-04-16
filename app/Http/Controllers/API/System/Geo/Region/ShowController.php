<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Models\Region;

class ShowController extends BaseController
{
    public function __invoke(Region $region)
    {
        return $region;
    }
}
