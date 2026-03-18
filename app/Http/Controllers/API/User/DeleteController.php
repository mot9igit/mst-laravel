<?php

namespace App\Http\Controllers\API\User;

class DeleteController extends BaseController
{
    public function __invoke(int $user_id)
    {
        return $this->service->delete($user_id);
    }
}
