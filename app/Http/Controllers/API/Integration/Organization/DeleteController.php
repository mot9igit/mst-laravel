<?php

namespace App\Http\Controllers\API\Integration\Organization;

class DeleteController extends BaseController
{
    public function __invoke(int $organization_id)
    {
        $this->service->delete($organization_id);
    }
}
