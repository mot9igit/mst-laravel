<?php

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Models\Organization;
use App\Models\Vendor;
use App\Services\Tools\FileUploaderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorRepository
{
    public function __construct(
        private readonly FileUploaderService $uploaderService,
    ){}

    /**
     * Берем таблицу Производителей
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
            $vendors = Vendor::where('name', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $vendors = Vendor::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $vendors;
    }

    /**
     * Удаление Бренда
     *
     * @param int $organization_id
     * @return string
     */
    public function delete(int $vendor_id){
        $vendor = Vendor::findOrFail($vendor_id);
        DB::beginTransaction();
        try{
            $vendor_id = $vendor->id;
            $response_file = $this->uploaderService->delete("vendors/{$vendor_id}/");
            // Log::error(print_r($response_file, 1));
            if (App::environment(['local'])) {
                $response = $vendor->forceDelete();
            }else{
                $response = $vendor->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание бренда в БД
     *
     * @param array $validated
     * @return Vendor|bool
     */
    public function create(array $validated): Vendor | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'name' => $validated['name']
            ];
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $createdata['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $createdata['thumbnail'] = $validated['thumbnail'];
            }
            $vendor = Vendor::create($createdata);
            DB::commit();
            return $vendor;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания бренда: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление Бренда в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $vendor = Vendor::findOrFail($id);
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name']
            ];
            if(isset($validated['description'])){
                $updateData['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $updateData['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $updateData['thumbnail'] = $validated['thumbnail'];
            }
            $updatedVendor = $vendor->update($updateData);
            DB::commit();
            return $vendor;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении бренда: ' . $e->getMessage());
            return false;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении бренда: ' . $e->getMessage());
            return false;
        }
    }
}
