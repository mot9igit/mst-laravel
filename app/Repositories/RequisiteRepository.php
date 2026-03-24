<?php

namespace App\Repositories;

use App\Models\Requisite;
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
