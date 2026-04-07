<?php

namespace App\Http\Controllers\API\Integration\BankRequisite;

class DeleteController extends BaseController
{
    public function __invoke(int $bankrequisite)
    {
        $this->service->delete($bankrequisite);
    }
}
