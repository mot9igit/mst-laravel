<?php

namespace App\Repositories;

use App\Models\Store;
use App\Services\Tools\FileUploaderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
     * @throws Throwable
     */
    public function delete(int $store_id): string
    {
        $store = Store::findOrFail($store_id);
        DB::beginTransaction();
        try{
            $store_id = $store->id;
            $response_file = $this->uploaderService->delete("stores/{$store_id}/");
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
     * @throws Throwable
     */
    public function create(array $validated): Store | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name']
            ];
            if(isset($validated['name_short'])){
                $createdata['name_short'] = $validated['name_short'];
            }
            if(isset($validated['address'])){
                if (is_array($validated['address'])) {
                    $createdata['address'] = $validated['address']['value'];
                } else {
                    $createdata['address'] = $validated['address'];
                }
            }else{
                $createdata['address'] = "";
            }
            if(isset($validated['active'])){
                $createdata['active'] = $validated['active'];
            }
            if(isset($validated['marketplace'])){
                $createdata['marketplace'] = $validated['marketplace'];
            }
            if(isset($validated['opt_marketplace'])){
                $createdata['opt_marketplace'] = $validated['opt_marketplace'];
            }
            if(isset($validated['check_remains'])){
                $createdata['check_remains'] = $validated['check_remains'];
            }
            if(isset($validated['check_docs'])){
                $createdata['check_docs'] = $validated['check_docs'];
            }
            if(isset($validated['coordinates'])){
                $createdata['coordinates'] = $validated['coordinates'];
            }
            if(isset($validated['integration_type'])){
                $createdata['integration_type'] = $validated['integration_type']['code'];
            }
            if(isset($validated['yml_file'])){
                $createdata['yml_file'] = $validated['yml_file'];
            }
            if(isset($validated['city_id'])){
                $createdata['city_id'] = $validated['city_id']['id'];
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
            if(isset($validated['name_short'])){
                $updateData['name_short'] = $validated['name_short'];
            }
            if(isset($validated['address'])){
                if (is_array($validated['address'])) {
                    $updateData['address'] = $validated['address']['value'];
                } else {
                    $updateData['address'] = $validated['address'];
                }
            }else{
                $updateData['address'] = "";
            }
            if(isset($validated['active'])){
                $updateData['active'] = $validated['active'];
            }
            if(isset($validated['marketplace'])){
                $updateData['marketplace'] = $validated['marketplace'];
            }
            if(isset($validated['opt_marketplace'])){
                $updateData['opt_marketplace'] = $validated['opt_marketplace'];
            }
            if(isset($validated['check_remains'])){
                $updateData['check_remains'] = $validated['check_remains'];
            }
            if(isset($validated['check_docs'])){
                $updateData['check_docs'] = $validated['check_docs'];
            }
            if(isset($validated['coordinates'])){
                $updateData['coordinates'] = $validated['coordinates'];
            }
            if(isset($validated['integration_type'])){
                $updateData['integration_type'] = $validated['integration_type']['code'];
            }
            if(isset($validated['yml_file'])){
                $updateData['yml_file'] = $validated['yml_file'];
            }
            if(isset($validated['city_id'])){
                $updateData['city_id'] = $validated['city_id']['id'];
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
