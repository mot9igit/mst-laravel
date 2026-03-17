<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\UpdatePasswordRequest;
use Illuminate\Http\Request;

class UpdatePasswordController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request, $user){
        $validated = $request->validated();
        $response = $this->service->updatePassword($user, $validated);
        return $response;
    }
}
