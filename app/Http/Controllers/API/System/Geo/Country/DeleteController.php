<?php

namespace App\Http\Controllers\API\System\Geo\Country;

class DeleteController extends BaseController
{
    public function __invoke(int $country_id)
    {
        $this->service->delete($country_id);
    }
}
