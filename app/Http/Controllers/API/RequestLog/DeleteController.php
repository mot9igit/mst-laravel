<?php

namespace App\Http\Controllers\API\RequestLog;

class DeleteController extends BaseController
{
    public function __invoke(int $id)
    {
        $this->service->delete($id);
    }
}
