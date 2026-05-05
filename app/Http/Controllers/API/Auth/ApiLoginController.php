<?php

namespace App\Http\Controllers\API\Auth;


use App\Http\Requests\API\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

class ApiLoginController extends BaseController
{
    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = $this->service->getByEmail($validated['email']);

        if(!$user) {
            return response()->json([
                'message' => 'Пользователь не найден'
            ], 404);
        }

        if(!Hash::check($validated['password'], $user->getAuthPassword())) {
            return response()->json([
                'message' => 'Неверный пароль',
            ], 404);
        }

        $token = $user->createToken('api_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
