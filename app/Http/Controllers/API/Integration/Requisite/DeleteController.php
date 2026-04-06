<?php

namespace App\Http\Controllers\API\Integration\Requisite;

class DeleteController extends BaseController
{
    public function __invoke(int $requisite_id)
    {
        $this->service->delete($requisite_id);
    }
}
