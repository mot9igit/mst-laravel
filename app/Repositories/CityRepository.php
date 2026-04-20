<?php
namespace App\Repositories;

use App\Models\City;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class CityRepository
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
            $cities = City::where('name', 'like', '%'.$filter.'%')
                ->with('region')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $cities = City::with('region')->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $cities;
    }

    /**
     * Удаление Города
     *
     * @param int $city_id
     * @return string
     */
    public function delete(int $city_id){
        $city = City::findOrFail($city_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $city->forceDelete();
            }else{
                $response = $city->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Города в БД
     *
     * @param array $validated
     * @return City|bool
     */
    public function create(array $validated): City | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'name_r' => $validated['name_r']
            ];
            if(isset($validated['region_id'])){
                $createdata['region_id'] = $validated['region_id']['id'];
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
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            $city = City::create($createdata);
            DB::commit();
            return $city;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания города: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление города в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $validated): mixed
    {
        $city = City::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'name_r' => $validated['name_r']
            ];
            if(isset($validated['region_id'])){
                $updateData['region_id'] = $validated['region_id']['id'];
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
            $updatedCity = $city->update($updateData);
            DB::commit();
            return $city;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Города: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Города: ' . $e->getMessage());
            return false;
        }
    }
}
