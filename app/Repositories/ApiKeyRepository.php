<?php
namespace App\Repositories;

use App\Models\ApiKey;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiKeyRepository
{
    /**
     * Получение списка API ключей
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator {
        $perpage = $data['perpage'] ?? 12;
        $filter = $data['filter'] ?? null;
       return ApiKey::whereAny([
           'api_keys.description',
           'api_keys.key',
       ], 'LIKE', '%' . $filter . '%')
       ->join('stores', 'stores.id', '=', 'api_keys.store_id')
       ->select('api_keys.*', 'stores.name as store_name')
       ->paginate($perpage);
    }

    /**
     * Удаление API ключа
     *
     * @param int $api_key_id
     * @return string
     */
    public function delete(int $api_key_id){
        $apiKey = ApiKey::findOrFail($api_key_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $apiKey->forceDelete();
            }else{
                $response = $apiKey->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание api ключа
     *
     * @param array $validated
     * @return ApiKey|bool
     */
    public function create(array $validated): ApiKey | bool
    {
        DB::beginTransaction();
        try {
            $key = ApiKey::create($validated);
            DB::commit();
            return $key;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания api ключа: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление api ключа в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $validated): mixed
    {
        $apiKey = ApiKey::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedApiKey = $apiKey->update($validated);
            DB::commit();
            return $updatedApiKey;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении api ключа: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении api ключа: ' . $e->getMessage());
            return false;
        }
    }
}
