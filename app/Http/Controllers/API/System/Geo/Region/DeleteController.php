<?php

namespace App\Http\Controllers\API\System\Geo\Region;

class DeleteController extends BaseController
{
    public function __invoke(int $region_id)
    {
        $this->service->delete($region_id);
    }
}
