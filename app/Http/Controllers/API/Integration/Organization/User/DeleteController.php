<?php

namespace App\Http\Controllers\API\Integration\Organization\User;

use App\Http\Controllers\API\Integration\Organization\BaseController;

class DeleteController extends BaseController
{
    public function __invoke(int $organization, int $user)
    {
        $this->service->deleteUser($organization, $user);
    }
}
