<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Models\Region;

class ShowController extends BaseController
{
    public function __invoke(int $regionId)
    {
        $region = Region::findOrFail($regionId)->with('country')->firstOrFail();
        return $region;
    }
}
