<?php

namespace App\Http\Controllers\API\System\Geo\City;

class DeleteController extends BaseController
{
    public function __invoke(int $city_id)
    {
        $this->service->delete($city_id);
    }
}
