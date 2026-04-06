<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequisiteRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Берем таблицу Организаций
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator{
        $org_id = $data['org_id'];
        $perpage = $data['perpage'] ?? 12;
        $filter = $data['filter'] ?? '';
        $sort = $data['sort'] ?? [];

        $organization = Organization::findOrFail($org_id);

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
            $requisites = $organization->requisites()
                ->where('name', 'like', '%'.$filter.'%')
                ->orWhere('inn', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $requisites = $organization->requisites()
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $requisites;
    }

    public function create($validated){
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name'],
                'inn' => $validated['inn'],
                'ogrn' => $validated['ogrn']
            ];
            if(isset($validated['kpp'])){
                $createdata['kpp'] = $validated['kpp'];
            }else{
                $createdata['kpp'] = "";
            }
            if(isset($validated['ur_address'])){
                if (is_array($validated['ur_address'])) {
                    $createdata['ur_address'] = $validated['ur_address']['value'];
                } else {
                    $createdata['ur_address'] = $validated['ur_address'];
                }
            }else{
                $createdata['ur_address'] = "";
            }
            if(isset($validated['fact_address'])){
                if(is_array($validated['fact_address'])){
                    $createdata['fact_address'] = $validated['fact_address']['value'];
                }else{
                    $createdata['fact_address'] = $validated['fact_address'];
                }
            }else{
                $createdata['fact_address'] = "";
            }
            $requisite = Requisite::create($createdata);
            DB::commit();
            return $requisite;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания реквизитов: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление реквизитов
     *
     * @param int $requisite_id
     * @return string
     */
    public function delete(int $requisite_id){
        $requisite = Requisite::findOrFail($requisite_id);
        DB::beginTransaction();
        try{
            $requisite->organizations()->detach();
            if (App::environment(['local'])) {
                $response = $requisite->forceDelete();
            }else{
                $response = $requisite->delete();
            }
            DB::commit();
            DB::rollback();
        }catch(\Exception $e){
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Обновление пользователя в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $requisite = Requisite::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'inn' => $validated['inn'],
                'ogrn' => $validated['ogrn']
            ];
            if(isset($validated['kpp'])){
                $updateData['kpp'] = $validated['kpp'];
            }else{
                $updateData['kpp'] = "";
            }
            if(isset($validated['ur_address'])){
                if (is_array($validated['ur_address'])) {
                    $updateData['ur_address'] = $validated['ur_address']['value'];
                } else {
                    $updateData['ur_address'] = $validated['ur_address'];
                }
            }else{
                $updateData['ur_address'] = "";
            }
            if(isset($validated['fact_address'])){
                if(is_array($validated['fact_address'])){
                    $updateData['fact_address'] = $validated['fact_address']['value'];
                }else{
                    $updateData['fact_address'] = $validated['fact_address'];
                }
            }else{
                $updateData['fact_address'] = "";
            }
            $updatedRequisite = $requisite->update($updateData);
            DB::commit();
            return $updatedRequisite;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении реквизитов: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении реквизитов: ' . $e->getMessage());
            return false;
        }
    }
}
