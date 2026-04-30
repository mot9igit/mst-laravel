<?php

namespace App\Repositories;

use App\Models\StoreRemain;
use App\Models\StoreRemainCatalog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreRemainRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    /**
     * Берем таблицу Номенклатуры
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
            $remains = StoreRemain::where('name', 'like', '%'.$filter.'%')
                ->orWhere('article', 'like', '%'.$filter.'%')
                ->orWhere('description', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $remains = StoreRemain::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $remains;
    }

    /**
     * Удаление Номенклатуры
     *
     * @param int $remain_id
     * @return string
     */
    public function delete(int $remain_id){
        $remain = StoreRemain::findOrFail($remain_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $remain->forceDelete();
            }else{
                $response = $remain->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Каталога в БД
     *
     * @param array $validated
     * @return StoreRemain|bool
     */
    public function create(array $validated): StoreRemain | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'article' => $validated['article'],
                'store_id' => $validated['store_id']
            ];
            if(isset($validated['product_id'])){
                $createdata['product_id'] = $validated['product_id']['id'];
            }
            if(isset($validated['catalog_id'])){
                $createdata['catalog_id'] = $validated['catalog_id']['id'];
            }
            if(isset($validated['vendor_id'])){
                $createdata['vendor_id'] = $validated['vendor_id']['id'];
            }
            if(isset($validated['status'])){
                $createdata['status'] = $validated['status'];
            }
            if(isset($validated['catalog_guid'])){
                $createdata['catalog_guid'] = $validated['catalog_guid'];
            }
            if(isset($validated['barcode'])){
                $createdata['barcode'] = $validated['barcode'];
            }
            if(isset($validated['remains'])){
                $createdata['remains'] = $validated['remains'];
            }else{
                $createdata['remains'] = 0;
            }
            if(isset($validated['reserved'])){
                $createdata['reserved'] = $validated['reserved'];
            }else{
                $createdata['reserved'] = 0;
            }
            if(isset($validated['available'])){
                $createdata['available'] = $validated['available'];
            }else{
                $createdata['available'] = 0;
            }
            if(isset($validated['price'])){
                $createdata['price'] = $validated['price'];
            }else{
                $createdata['price'] = 0;
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            if(isset($validated['tags'])){
                $createdata['tags'] = $validated['tags'];
            }
            $remain = StoreRemain::create($createdata);
            DB::commit();
            return $remain;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания Номенклатуры: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Каталога в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $remain = StoreRemain::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'article' => $validated['article'],
                'store_id' => $validated['store_id']
            ];
            if(isset($validated['product_id'])){
                $updateData['product_id'] = $validated['product_id']['id'];
            }
            if(isset($validated['catalog_id'])){
                $updateData['catalog_id'] = $validated['catalog_id']['id'];
            }
            if(isset($validated['vendor_id'])){
                $updateData['vendor_id'] = $validated['vendor_id']['id'];
            }
            if(isset($validated['status'])){
                $updateData['status'] = $validated['status'];
            }
            if(isset($validated['catalog_guid'])){
                $updateData['catalog_guid'] = $validated['catalog_guid'];
            }
            if(isset($validated['barcode'])){
                $updateData['barcode'] = $validated['barcode'];
            }
            if(isset($validated['remains'])){
                $updateData['remains'] = $validated['remains'];
            }else{
                $updateData['remains'] = 0;
            }
            if(isset($validated['reserved'])){
                $updateData['reserved'] = $validated['reserved'];
            }else{
                $updateData['reserved'] = 0;
            }
            if(isset($validated['available'])){
                $updateData['available'] = $validated['available'];
            }else{
                $updateData['available'] = 0;
            }
            if(isset($validated['price'])){
                $updateData['price'] = $validated['price'];
            }else{
                $updateData['price'] = 0;
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            if(isset($validated['tags'])){
                $updateData['tags'] = $validated['tags'];
            }
            $updatedRemain = $remain->update($updateData);
            DB::commit();
            return $remain;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Номенклатуры: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Номенклатуры: ' . $e->getMessage());
            return false;
        }
    }
}
