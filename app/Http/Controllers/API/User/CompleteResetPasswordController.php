<?php

namespace App\Http\Controllers\API\User;

use App\Exceptions\User\UserNotFoundByTokenException;
use App\Http\Requests\API\User\ResetPasswordByTokenRequest;
use Exception;
use function Laravel\Prompts\error;

class CompleteResetPasswordController extends BaseController
{
    public function __invoke(ResetPasswordByTokenRequest $request){
        $validated = $request->validated();
        try {
            $this->service->completeResetPassword($validated['token'], $validated['password']);
            return response()->json([
                'success' => true,
                'message' => 'Пароль успешно обновлен'
            ], 200);
        } catch (Exception $e) {
            if ($e instanceof UserNotFoundByTokenException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 404);
            }
            return response()->json([
                'success' => false,
                'message' => 'Неизвестная ошибка'
            ], 500);
        }
    }
}
