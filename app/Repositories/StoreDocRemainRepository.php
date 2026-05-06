<?php

namespace App\Repositories;

use App\Models\StoreDocRemain;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreDocRemainRepository
{
    public function __construct(){}

    /**
     * Берем таблицу Номенклатуры Документов
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

        $allowedSorts = ['id', 'guid', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if($filter != ''){
            $docRemains = StoreDocRemain::where('guid', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $docRemains = StoreDocRemain::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $docRemains;
    }

    /**
     * Удаление Номенклатуры Документов
     *
     * @param int $doc_remain_id
     * @return string
     */
    public function delete(int $doc_remain_id){
        $docRemain = StoreDocRemain::findOrFail($doc_remain_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $docRemain->forceDelete();
            }else{
                $response = $docRemain->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Номенклатуры Документов в БД
     *
     * @param array $validated
     * @return StoreDocRemain|bool
     */
    public function create(array $validated): StoreDocRemain | bool
    {
        DB::beginTransaction();
        try {
            $docRemain = StoreDocRemain::create($validated);
            DB::commit();
            return $docRemain;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания Документа: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Номенклатуры Документа в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $docRemain = StoreDocRemain::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedVendor = $docRemain->update($validated);
            DB::commit();
            return $docRemain;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Номенклатуры Документа: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Номенклатуры Документа: ' . $e->getMessage());
            return false;
        }
    }
}
