<?php
namespace App\Repositories;

use App\Models\Region;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegionRepository
{
    /**
     * Берем таблицу Городов
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
            $regions = Region::where('name', 'like', '%'.$filter.'%')
                ->with('country')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $regions = Region::with('country')->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $regions;
    }

    /**
     * Удаление Региона
     *
     * @param int $region_id
     * @return string
     */
    public function delete(int $region_id){
        $region = Region::findOrFail($region_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $region->forceDelete();
            }else{
                $response = $region->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Региона в БД
     *
     * @param array $validated
     * @return Region|bool
     */
    public function create(array $validated): Region | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'name_r' => $validated['name_r'],
                'code' => $validated['code']
            ];
            if(isset($validated['country_id'])){
                $createdata['country_id'] = $validated['country_id']['id'];
            }
            if(isset($validated['key'])){
                $createdata['key'] = Str::slug($validated['key']);
            }else{
                $createdata['key'] = Str::slug($validated['name']);
            }
            if(isset($validated['population'])){
                $createdata['population'] = $validated['population'];
            }
            if(isset($validated['fias_id'])){
                $createdata['fias_id'] = $validated['fias_id'];
            }
            if(isset($validated['postal_code'])){
                $createdata['postal_code'] = $validated['postal_code'];
            }
            if(isset($validated['active'])){
                $createdata['active'] = $validated['active'];
            }else{
                $createdata['active'] = 0;
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            $region = Region::create($createdata);
            DB::commit();
            return $region;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания региона: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление города в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $region = Region::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'name_r' => $validated['name_r'],
                'code' => $validated['code']
            ];
            if(isset($validated['country_id'])){
                $updateData['country_id'] = $validated['country_id']['id'];
            }
            if(isset($validated['key'])){
                $updateData['key'] = Str::slug($validated['key']);
            }else{
                $updateData['key'] = Str::slug($validated['name']);
            }
            if(isset($validated['population'])){
                $updateData['population'] = $validated['population'];
            }
            if(isset($validated['active'])){
                $updateData['active'] = $validated['active'];
            }else{
                $updateData['active'] = 0;
            }
            if(isset($validated['fias_id'])){
                $updateData['fias_id'] = $validated['fias_id'];
            }
            if(isset($validated['postal_code'])){
                $updateData['postal_code'] = $validated['postal_code'];
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            $updatedRegion = $region->update($updateData);
            DB::commit();
            return $region;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Региона: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Региона: ' . $e->getMessage());
            return false;
        }
    }
}
