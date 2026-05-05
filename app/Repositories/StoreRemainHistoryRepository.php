<?php

namespace App\Repositories;

use App\Models\StoreRemainHistory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreRemainHistoryRepository
{
    public function __construct()
    {}

    /**
     * Берем таблицу Истории
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

        $allowedSorts = ['id', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }


        $history = StoreRemainHistory::orderBy($sortBy, $sortDir)
            ->where('remain_id', $data['remain_id'])
            ->paginate($perpage);


        return $history;
    }

    /**
     * Удаление Истории
     *
     * @param int $history_id
     * @return string
     */
    public function delete(int $history_id){
        $history = StoreRemainHistory::findOrFail($history_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $history->forceDelete();
            }else{
                $response = $history->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Истории в БД
     *
     * @param array $validated
     * @return StoreRemainHistory|bool
     */
    public function create(array $validated): StoreRemainHistory | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'date' => $validated['date'],
                'remain_id' => $validated['remain_id'],
            ];
            if(isset($validated['name'])){
                $createdata['name'] = $validated['name'];
            }else{
                $createdata['name'] = "";
            }
            if(isset($validated['article'])){
                $createdata['article'] = $validated['article'];
            }else{
                $createdata['article'] = "";
            }
            if(isset($validated['remains'])){
                $createdata['remains'] = $validated['remains'];
            }
            if(isset($validated['reserved'])){
                $createdata['reserved'] = $validated['reserved'];
            }
            if(isset($validated['available'])){
                $createdata['available'] = $validated['available'];
            }
            if(isset($validated['price'])){
                $createdata['price'] = $validated['price'];
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            $history = StoreRemainHistory::create($createdata);
            DB::commit();
            return $history;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания Истории Номенклатуры: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Истории в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $history = StoreRemainHistory::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'date' => $validated['date'],
                'remain_id' => $validated['remain_id'],
            ];
            if(isset($validated['name'])){
                $updateData['name'] = $validated['name'];
            }else{
                $updateData['name'] = "";
            }
            if(isset($validated['article'])){
                $updateData['article'] = $validated['article'];
            }else{
                $updateData['article'] = "";
            }
            if(isset($validated['remains'])){
                $updateData['remains'] = $validated['remains'];
            }
            if(isset($validated['reserved'])){
                $updateData['reserved'] = $validated['reserved'];
            }
            if(isset($validated['available'])){
                $updateData['available'] = $validated['available'];
            }
            if(isset($validated['price'])){
                $updateData['price'] = $validated['price'];
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            $updatedHistory = $history->update($updateData);
            DB::commit();
            return $history;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Истории Номенклатуры: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Истории Номенклатуры: ' . $e->getMessage());
            return false;
        }
    }
}
