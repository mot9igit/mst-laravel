<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\API\User\ResetPasswordRequest;

class ResetPasswordController extends BaseController
{
    public function __invoke(ResetPasswordRequest $request)
    {
        $validated = $request->validated();
        $this->service->resetPassword($validated['email']);
        return response()->json([
            'message' => 'Ссылка отправлена на почту',
            'success' => true
        ], 201);
    }
}
