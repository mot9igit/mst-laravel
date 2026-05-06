<?php

namespace App\Http\Controllers\API\Integration\ApiKey;

class ShowController extends BaseController
{
    public function __invoke(int $id)
    {
        return $this->service->delete($id);
    }
}
