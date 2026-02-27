<?php

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    /**
     * Создание пользователя в БД
     *
     * @param array $validated
     * @return mixed
     * @throws UserException
     */
    public function create(array $validated){
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'fullname' => $validated['fullname'],
                'active' => $validated['active'],
                'sudo' => $validated['sudo'],
                'password' => $validated['password']
            ]);
            DB::commit();
            return $user;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания пользователя: ' . $e->getMessage());
            throw new UserException("Ошибка создания пользователя: {$e->getMessage()}", 500, $e->errors);
        }
    }

    /**
     * Обновление пользователя в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     * @throws UserException
     */
    public function update(int $id, array $validated){
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedUser = $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'fullname' => $validated['fullname'],
                'active' => $validated['active'],
                'sudo' => $validated['sudo'],
                'password' => $validated['password']
            ]);
            DB::commit();
            return $updatedUser;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении пользователя: ' . $e->getMessage());
            throw new UserException("Ошибка БД при обновлении пользователя: {$e->getMessage()}", 422, $e->errors);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении пользователя: ' . $e->getMessage());
            throw new UserException("Ошибка БД при обновлении пользователя: {$e->getMessage()}", 500, $e->errors);
        }
    }
}
