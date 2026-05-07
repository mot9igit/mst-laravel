<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;


class ShowController extends BaseController
{
    public function __invoke(int $docId, int $remainId)
    {
        return $this->service->findById($remainId);
    }
}
