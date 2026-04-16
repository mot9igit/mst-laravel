<?php

namespace App\Http\Controllers\API\System\Geo\City;

use App\Models\City;

class ShowController extends BaseController
{
    public function __invoke(City $city)
    {
        return $city;
    }
}
