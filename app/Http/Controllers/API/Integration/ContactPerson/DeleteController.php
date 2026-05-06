<?php

namespace App\Http\Controllers\API\Integration\ContactPerson;


class DeleteController extends BaseController
{
    public function __invoke(int $contract_person_id)
    {
        $this->service->delete($contract_person_id);
    }
}
