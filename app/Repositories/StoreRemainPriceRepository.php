<?php

namespace App\Repositories;

use App\Models\StoreRemainPrice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreRemainPriceRepository
{
    public function __construct()
    {}

    /**
     * Берем таблицу Цен
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
            $catalogs = StoreRemainPrice::where('name', 'like', '%'.$filter.'%')
                ->orWhere('guid', 'like', '%'.$filter.'%')
                ->where('remain_id', $data['remain_id'])
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $catalogs = StoreRemainPrice::orderBy($sortBy, $sortDir)
                ->where('remain_id', $data['remain_id'])
                ->paginate($perpage);
        }

        return $catalogs;
    }

    /**
     * Удаление Цены
     *
     * @param int $price_id
     * @return string
     */
    public function delete(int $price_id){
        $price = StoreRemainPrice::findOrFail($price_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $price->forceDelete();
            }else{
                $response = $price->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Цены в БД
     *
     * @param array $validated
     * @return StoreRemainPrice|bool
     */
    public function create(array $validated): StoreRemainPrice | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'price' => $validated['price'],
                'remain_id' => $validated['remain_id'],
            ];
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            $price = StoreRemainPrice::create($createdata);
            DB::commit();
            return $price;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания цены: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Цены в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $price = StoreRemainPrice::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'price' => $validated['price'],
                'remain_id' => $validated['remain_id'],
            ];
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            $updatedPrice = $price->update($updateData);
            DB::commit();
            return $price;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Цены: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Цены: ' . $e->getMessage());
            return false;
        }
    }
}
