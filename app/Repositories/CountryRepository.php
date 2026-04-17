<?php
namespace App\Repositories;

use App\Models\Country;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CountryRepository
{
    /**
     * Берем таблицу Стран
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
            $countries = Country::where('name', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $countries = Country::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $countries;
    }

    /**
     * Удаление Страны
     *
     * @param int $country_id
     * @return string
     */
    public function delete(int $country_id){
        $country = Country::findOrFail($country_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $response = $country->forceDelete();
            }else{
                $response = $country->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Страны в БД
     *
     * @param array $validated
     * @return Country|bool
     */
    public function create(array $validated): Country | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'active' => 1
            ];
            if(isset($validated['key'])){
                $createdata['key'] = Str::slug($validated['key']);
            }else{
                $createdata['key'] = Str::slug($validated['name']);
            }
            if(isset($validated['population'])){
                $createdata['population'] = $validated['population'];
            }
            if(isset($validated['active'])){
                $createdata['active'] = $validated['active'];
            }else{
                $createdata['active'] = 0;
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            $country = Country::create($createdata);
            DB::commit();
            return $country;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания страны: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление страны в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $country = Country::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'active' => 1
            ];
            if(isset($validated['key'])){
                $updateData['key'] = Str::slug($validated['key']);
            }else{
                $updateData['key'] = Str::slug($validated['name']);
            }
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            if(isset($validated['active'])){
                $updateData['active'] = $validated['active'];
            }else{
                $updateData['active'] = 0;
            }
            if(isset($validated['population'])){
                $updateData['population'] = $validated['population'];
            }
            $updatedCountry = $country->update($updateData);
            DB::commit();
            return $country;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении страны: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении страны: ' . $e->getMessage());
            return false;
        }
    }
}
