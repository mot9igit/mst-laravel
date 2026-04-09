<?php

namespace App\Http\Controllers\API\ProductCategory;

class DeleteController extends BaseController
{
    public function __invoke(int $caregory_id)
    {
        $this->service->delete($caregory_id);
    }
}
