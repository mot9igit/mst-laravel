<?php
namespace App\Repositories;

use App\Models\RequestLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RequestLogRepository
{
    /**
     * Получение списка логов
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator {
        $perpage = $data['perpage'] ?? 12;
       return RequestLog::query()
       ->paginate($perpage);
    }

    /**
     * Удаление лога
     *
     * @param int $log_id
     * @return string
     */
    public function delete(int $log_id){
        $apiKey = RequestLog::findOrFail($log_id);
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
     * Создание лога
     *
     * @param array $validated
     * @return RequestLog|bool
     */
    public function create(array $validated): RequestLog | bool
    {
        DB::beginTransaction();
        try {
            $key = RequestLog::create($validated);
            DB::commit();
            return $key;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания лога: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление лога в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $validated): mixed
    {
        $log = RequestLog::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedLog = $log->update($validated);
            DB::commit();
            return $updatedLog;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении лога: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении лога: ' . $e->getMessage());
            return false;
        }
    }
}
