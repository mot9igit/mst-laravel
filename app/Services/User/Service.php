<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class Service
{
    public $user;
    public $user_id;

    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
        $this->user = Auth::user();
        $this->user_id = Auth::id();
    }

    public function get(array $data): LengthAwarePaginator{
        return $this->userRepository->get($data);
    }

    /**
     * Создание пользователя
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
     */
    public function store($validated){
        $user = $this->userRepository->create($validated);
        return response()->json([
            'message' => 'Пользователь успешно создан',
            'user' => $user
        ], 201);
    }

    /**
     * Обновление пользователя
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
     */
    public function update(int $id, array $validated){
        $user = $this->userRepository->update($id, $validated);
        return response()->json([
            'message' => 'Пользователь успешно обновлен',
            'user' => $user
        ], 201);
    }

    public function updatePassword(int $id, array $validated){
        $user = $this->userRepository->updatePassword($id, $validated);
        return response()->json([
            'message' => 'Пароль успешно обновлен',
            'user' => $user
        ], 201);
    }
}
