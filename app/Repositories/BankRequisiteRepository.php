<?php

namespace App\Repositories;

use App\Models\BankRequisite;
use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankRequisiteRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    /**
     * Берем таблицу Банковских реквизитов
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function get(array $data): LengthAwarePaginator{
        $org_id = $data['org_id'];
        $requisite_id = $data['requisite_id'];
        $perpage = $data['perpage'] ?? 12;
        $filter = $data['filter'] ?? '';
        $sort = $data['sort'] ?? [];

        $requisite = Requisite::findOrFail($requisite_id);

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
            $requisites = $requisite->bankRequisites()
                ->where('name', 'like', '%'.$filter.'%')
                ->orWhere('bik', 'like', '%'.$filter.'%')
                ->orWhere('number', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $requisites = $requisite->bankRequisites()
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
                'bik' => $validated['bik'],
                'number' => $validated['number'],
                'knumber' => $validated['knumber'],
                'requisite_id' => $validated['requisite_id']
            ];
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }else{
                $createdata['description'] = "";
            }
            $requisite = BankRequisite::create($createdata);
            DB::commit();
            return $requisite;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания банковских реквизитов: ' . $e->getMessage());
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
        $requisite = BankRequisite::findOrFail($requisite_id);
        DB::beginTransaction();
        try{
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
     * Обновление реквизитов в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $requisite = BankRequisite::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'bik' => $validated['bik'],
                'number' => $validated['number'],
                'knumber' => $validated['knumber'],
                'requisite_id' => $validated['requisite_id']
            ];
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }else{
                $updateData['description'] = "";
            }
            $updatedRequisite = $requisite->update($updateData);
            DB::commit();
            return $updatedRequisite;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении банковских реквизитов: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении банковских реквизитов: ' . $e->getMessage());
            return false;
        }
    }
}
