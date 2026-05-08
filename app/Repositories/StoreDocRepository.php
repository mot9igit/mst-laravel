<?php

namespace App\Repositories;

use App\Models\StoreDoc;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreDocRepository
{
    public function __construct(){}

    /**
     * Берем таблицу Документов
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

        $allowedSorts = ['id', 'guid', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if($filter != ''){
            $docs = StoreDoc::where('guid', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $docs = StoreDoc::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $docs;
    }

    public function findById(int $id): StoreDoc | null
    {
        return StoreDoc::findOrFail($id);
    }


    /**
     * Удаление Документа
     *
     * @param int $doc_id
     * @return string
     */
    public function delete(int $doc_id){
        $doc = StoreDoc::findOrFail($doc_id);
        DB::beginTransaction();
        try{
            if (App::environment(['local'])) {
                $doc->forceDelete();
            }else{
                $doc->delete();
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
        return $doc;
    }

    /**
     * Создание Документа в БД
     *
     * @param array $validated
     * @return StoreDoc| null
     */
    public function create(array $validated): StoreDoc | null
    {
        DB::beginTransaction();
        try {
            $doc = StoreDoc::create($validated);
            DB::commit();
            return $doc;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания Документа: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Обновление Документа в БД
     *
     * @param int $id
     * @param array $validated
     * @return mixed
     */
    public function update(int $id, array $validated): mixed
    {
        $doc = StoreDoc::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedVendor = $doc->update($validated);
            DB::commit();
            return $doc;
        }catch (QueryException $e) {
            DB::rollBack();
            Log::error('Ошибка БД при обновлении Документа: ' . $e->getMessage());
            throw $e;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Общая ошибка при обновлении Документа: ' . $e->getMessage());
            throw $e;
        }
    }
}
