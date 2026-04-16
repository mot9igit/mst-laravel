<?php

namespace App\Http\Controllers\API\System\Geo\Country;

use App\Models\Country;

class ShowController extends BaseController
{
    public function __invoke(Country $country)
    {
        return $country;
    }
}
