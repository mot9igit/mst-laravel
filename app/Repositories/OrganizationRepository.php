<?php

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Models\Organization;
use App\Models\User;
use App\Services\Tools\FileUploaderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OrganizationRepository
{

    public function __construct(
        private readonly FileUploaderService $uploaderService,
    ){

    }

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
                ->with()
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
            $org_id = $organization->id;
            $response_file = $this->uploaderService->delete("organizations/{$org_id}/");
            // Log::error(print_r($response_file, 1));
            // удаляем реквизиты
            foreach ($organization->requisites as $requisite) {
                if (App::environment(['local'])) {
                    $requisite->forceDelete();
                }else{
                    $requisite->delete();
                }
            }
            $organization->requisites()->detach();
            if (App::environment(['local'])) {
                $response = $organization->forceDelete();
            }else{
                $response = $organization->delete();
            }
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
    public function create(array $validated): Organization | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name']
            ];
            if(isset($validated['verified'])){
                $createdata['verified'] = $validated['verified'];
            }
            if(isset($validated['active'])){
                $createdata['active'] = $validated['active'];
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $createdata['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $createdata['thumbnail'] = $validated['thumbnail'];
            }
            $organization = Organization::create($createdata);
            DB::commit();
            return $organization;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания организации: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Организации в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $organization = Organization::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name']
            ];
            if(isset($validated['verified'])){
                $updateData['verified'] = $validated['verified'];
            }
            if(isset($validated['active'])){
                $updateData['active'] = $validated['active'];
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $updateData['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $updateData['thumbnail'] = $validated['thumbnail'];
            }
            $updatedOrganization = $organization->update($updateData);
            DB::commit();
            return $organization;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении организации: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении организации: ' . $e->getMessage());
            return false;
        }
    }

    public function getUsers($data): LengthAwarePaginator
    {
        $organization = Organization::findOrFail($data['org_id']);
        $query = $organization->users();

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
            $users = $query->where('name', 'like', '%'.$filter.'%')
                ->orWhere('email', 'like', '%'.$filter.'%')
                ->orWhere('fullname', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $users = $query->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $users;
    }

    public function storeUser($data): JsonResponse
    {
        DB::beginTransaction();
        try {
            $organization = Organization::findOrFail($data['org_id']);
            $organization->users()->attach([$data['user_id']['id']]);
            DB::commit();
            return response()->json([
                'message' => 'Организация успешно отредактирована',
                'organization' => $organization
            ], 201);
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении пользователей организации: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка БД при обновлении пользователей организации'
            ], 500);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении пользователей организации: ' . $e->getMessage());
            return response()->json([
                'message' => 'Общая ошибка БД при обновлении пользователей организации'
            ], 500);
        }
    }

    public function deleteUser(int $organization_id, int $user_id)
    {
        $organization = Organization::findOrFail($organization_id);
        DB::beginTransaction();
        try{
            $organization->users()->detach($user_id);
            DB::commit();
            return response()->json([
                'message' => "Пользователь успешно отвязан"
            ], 201);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
