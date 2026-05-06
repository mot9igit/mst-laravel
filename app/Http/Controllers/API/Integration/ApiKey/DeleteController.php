<?php

namespace App\Http\Controllers\API\Integration\ApiKey;

class DeleteController extends BaseController
{
    public function __invoke(int $id)
    {
        $this->service->delete($id);
    }
}
