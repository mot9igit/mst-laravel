<?php

namespace App\Services\User;

use App\Exceptions\User\UserNotFoundByEmailException;
use App\Exceptions\User\UserNotFoundByTokenException;
use App\Mail\ResetPassword;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


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
     * Удаление Пользователя
     *
     * @param int $user_id
     * @return int
     */
    public function delete(int $user_id): int{
        return $this->userRepository->delete($user_id);
    }

    /**
     * Создание пользователя
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\User\UserException
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
     * @throws \App\Exceptions\User\UserException
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

    public function getByEmail(string $email): User | null
    {
        return $this->userRepository->getByEmail($email);
    }

    public function resetPassword(string $email): bool
    {
        $uuid = Str::uuid()->toString();

        $user = $this->userRepository->getByEmail($email);

        if(!$user){
            throw new UserNotFoundByEmailException();
        }

        $this->userRepository->update($user->id, ['reset_password_token' => $uuid]);

        Mail::to($email)->send(new ResetPassword($uuid));
        return true;
    }

    public function completeResetPassword(string $token, string $password): bool
    {
        $user = $this->userRepository->getByResetPasswordToken($token);
        if(!$user){
            throw new UserNotFoundByTokenException();
        }

        $this->userRepository->update($user->id, [
            'reset_password_token' => null,
            'password' => $password
        ]);

        return true;
    }
}
