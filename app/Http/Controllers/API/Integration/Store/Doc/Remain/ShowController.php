<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;


class ShowController extends BaseController
{
    public function __invoke(int $id)
    {
        return $this->service->findById($id);
    }
}
