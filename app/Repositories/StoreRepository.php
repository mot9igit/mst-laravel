<?php

namespace App\Repositories;

use App\Models\Store;
use App\Services\Tools\FileUploaderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly FileUploaderService $uploaderService,
    )
    {}

    /**
     * Берем таблицу Точек Продаж
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
            $stores = Store::where('name', 'like', '%'.$filter.'%')
                ->orWhere('address', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $stores = Store::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $stores;
    }

    /**
     * Удаление Точки Продаж
     *
     * @param int $store_id
     * @return string
     */
    public function delete(int $store_id){
        $store = Store::findOrFail($store_id);
        DB::beginTransaction();
        try{
            $store_id = $store->id;
            $response_file = $this->uploaderService->delete("organizations/{$store_id}/");
            // Log::error(print_r($response_file, 1));
            if (App::environment(['local'])) {
                $response = $store->forceDelete();
            }else{
                $response = $store->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Точки Продаж в БД
     *
     * @param array $validated
     * @return Store|bool
     */
    public function create(array $validated): Store | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name']
            ];
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
            $store = Store::create($createdata);
            DB::commit();
            return $store;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания Точки Продаж: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Точки Продаж в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $store = Store::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name']
            ];
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
            $updatedStore = $store->update($updateData);
            DB::commit();
            return $store;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Точки Продаж: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Точки Продаж: ' . $e->getMessage());
            return false;
        }
    }
}
