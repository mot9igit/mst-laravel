<?php

namespace App\Repositories;

use App\Models\Region;
use App\Models\StoreRemainCatalog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreRemainCatalogRepository
{
    public function __construct()
    {}

    /**
     * Берем таблицу Каталогов
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
            $catalogs = StoreRemainCatalog::where('name', 'like', '%'.$filter.'%')
                ->where('store_id', $data['store_id'])
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $catalogs = StoreRemainCatalog::orderBy($sortBy, $sortDir)
                ->where('store_id', $data['store_id'])
                ->paginate($perpage);
        }

        return $catalogs;
    }

    /**
     * Удаление Каталога
     *
     * @param int $catalog_id
     * @return string
     */
    public function delete(int $catalog_id){
        $catalog = StoreRemainCatalog::findOrFail($catalog_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $catalog->forceDelete();
            }else{
                $response = $catalog->delete();
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
     * @return StoreRemainCatalog|bool
     */
    public function create(array $validated): StoreRemainCatalog | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'store_id' => $validated['store_id']
            ];
            if(isset($validated['parent_guid'])){
                $createdata['parent_guid'] = $validated['parent_guid'];
            }else{
                $createdata['parent_guid'] = '';
            }
            if(isset($validated['base_guid'])){
                $createdata['base_guid'] = $validated['base_guid'];
            }else{
                $createdata['base_guid'] = '';
            }
            if(isset($validated['name_alt'])){
                $createdata['name_alt'] = $validated['name_alt'];
            }else{
                $createdata['name_alt'] = '';
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            if(isset($validated['active'])){
                $createdata['active'] = $validated['active'];
            }else{
                $createdata['active'] = 0;
            }
            if(isset($validated['published'])){
                $createdata['published'] = $validated['published'];
            }else{
                $createdata['published'] = 0;
            }
            if(isset($validated['parent_id'])){
                $createdata['parent_id'] = $validated['parent_id']['id'];
            }
            $catalog = StoreRemainCatalog::create($createdata);
            DB::commit();
            return $catalog;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания каталога: ' . $e->getMessage());
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
        $catalog = StoreRemainCatalog::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'guid' => $validated['guid'],
                'store_id' => $validated['store_id']
            ];
            if(isset($validated['parent_guid'])){
                $updateData['parent_guid'] = $validated['parent_guid'];
            }else{
                $updateData['parent_guid'] = '';
            }
            if(isset($validated['base_guid'])){
                $updateData['base_guid'] = $validated['base_guid'];
            }else{
                $updateData['base_guid'] = '';
            }
            if(isset($validated['name_alt'])){
                $updateData['name_alt'] = $validated['name_alt'];
            }else{
                $updateData['name_alt'] = '';
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            if(isset($validated['active'])){
                $updateData['active'] = $validated['active'];
            }else{
                $updateData['active'] = 0;
            }
            if(isset($validated['published'])){
                $updateData['published'] = $validated['published'];
            }else{
                $updateData['published'] = 0;
            }
            if(isset($validated['parent_id'])){
                $updateData['parent_id'] = $validated['parent_id']['id'];
            }
            $updatedCatalog = $catalog->update($updateData);
            DB::commit();
            return $catalog;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Каталога: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Каталога: ' . $e->getMessage());
            return false;
        }
    }
}
