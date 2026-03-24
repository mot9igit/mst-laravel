<?php

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OrganizationRepository
{
    /**
     * Берем таблицу Организаций
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator{
        $perpage = $data['perpage'] ?? 12;
        $filter = $data['filter'] ?? '';
        $sort = $data['sort'] ?? [];

        $sortBy = 'id';
        $sortDir = 'desc';
        if(count($sort) > 0) {
            foreach ($sort as $key => $value) {
                $sortBy = $key;
                $sortDir = $value['dir'];
            }
        }

        $allowedSorts = ['id', 'name', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if($filter != ''){
            $organizations = Organization::where('name', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $organizations = Organization::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $organizations;
    }

    /**
     * Удаление Организации
     *
     * @param int $organization_id
     * @return string
     */
    public function delete(int $organization_id){
        $organization = Organization::findOrFail($organization_id);
        DB::beginTransaction();
        try{
            $response = $organization->delete();
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание организации в БД
     *
     * @param array $validated
     * @return Organization
     * @throws UserException
     */
    public function create(array $validated): Organization
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'active' => $validated['active'],
                'verified' => $validated['verified']
            ];
            if(isset($validated['image'])){
                $createdata['image'] = $validated['image'];
            }
            $organization = Organization::create($createdata);
            DB::commit();
            return $organization;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания организации: ' . $e->getMessage());
        }
    }

    public function createRequisite(array $validated){

    }

    public function updatePassword(int $id, array $validated){
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedUser = $user->update([
                'password' => $validated['new_password']
            ]);
            DB::commit();
            return $updatedUser;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении пароля пользователя: ' . $e->getMessage());
            throw new UserException("Ошибка БД при обновлении пароля пользователя: {$e->getMessage()}", 422, $e->errors);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении пользователя: ' . $e->getMessage());
            throw new UserException("Ошибка БД при обновлении пароля пользователя: {$e->getMessage()}", 500, $e->errors);
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
                'sudo' => $validated['sudo']
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
