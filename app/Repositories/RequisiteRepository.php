<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Pagination\LengthAwarePaginator;
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
}
