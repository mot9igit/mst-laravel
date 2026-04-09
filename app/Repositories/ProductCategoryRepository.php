<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\Tools\FileUploaderService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductCategoryRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly FileUploaderService $uploaderService
    )
    {}

    public function getAll() : Collection
    {
        $categories = ProductCategory::with('children')
            ->whereNull('parent_id')
            ->published()
            ->get();

        return $categories;
    }

    /**
     * Берем таблицу Категорий
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

        $allowedSorts = ['id', 'title', 'created_at', 'updated_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if($filter != ''){
            $categories = ProductCategory::where('title', 'like', '%'.$filter.'%')
                ->orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }else{
            $categories = ProductCategory::orderBy($sortBy, $sortDir)
                ->paginate($perpage);
        }

        return $categories;
    }

    /**
     * Удаление Категории
     *
     * @param int $category_id
     * @return string
     */
    public function delete(int $category_id){
        $organization = ProductCategory::findOrFail($category_id);
        DB::beginTransaction();
        try{
            $org_id = $organization->id;
            $response_file = $this->uploaderService->delete("category/{$org_id}/");
            if (App::environment(['local'])) {
                $response = $organization->forceDelete();
            }else{
                $response = $organization->delete();
            }
            DB::commit();
            DB::rollback();
        }catch(\Exception $e){
            $response = $e->getMessage();
        }
        return $response;
    }

    /**
     * Создание Категории в БД
     *
     * @param array $validated
     * @return ProductCategory
     */
    public function create(array $validated): ProductCategory | bool
    {
        DB::beginTransaction();
        try {
            $createdata = [
                'title' => $validated['title']
            ];
            if(isset($validated['longtitle'])){
                $createdata['longtitle'] = $validated['longtitle'];
            }
            if(isset($validated['seotitle'])){
                $createdata['seotitle'] = $validated['seotitle'];
            }
            if(isset($validated['seodescription'])){
                $createdata['seodescription'] = $validated['seodescription'];
            }
            if(isset($validated['slug'])){
                $createdata['slug'] = $validated['slug'];
            }
            if(isset($validated['show_in_menu'])){
                $createdata['show_in_menu'] = $validated['show_in_menu'];
            }
            if(isset($validated['published'])){
                $createdata['published'] = $validated['published'];
            }
            if(isset($validated['description'])){
                $createdata['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $createdata['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $createdata['thumbnail'] = $validated['thumbnail'];
            }
            if(isset($validated['parent_id'])){
                $createdata['parent_id'] = $validated['parent_id'];
            }
            $organization = ProductCategory::create($createdata);
            DB::commit();
            return $organization;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка создания категории товаров: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Создание Категории в БД
     *
     * @param int $id
     * @param array $validated
     * @return ProductCategory|bool
     */
    public function update(int $id, array $validated): ProductCategory | bool
    {
        $category = ProductCategory::findOrFail($id);
        DB::beginTransaction();
        try {
            $updatedata = [
                'title' => $validated['title']
            ];
            if(isset($validated['longtitle'])){
                $updatedata['longtitle'] = $validated['longtitle'];
            }
            if(isset($validated['seotitle'])){
                $updatedata['seotitle'] = $validated['seotitle'];
            }
            if(isset($validated['seodescription'])){
                $updatedata['seodescription'] = $validated['seodescription'];
            }
            if(isset($validated['slug'])){
                $updatedata['slug'] = $validated['slug'];
            }
            if(isset($validated['show_in_menu'])){
                $updatedata['show_in_menu'] = $validated['show_in_menu'];
            }
            if(isset($validated['published'])){
                $updatedata['published'] = $validated['published'];
            }
            if(isset($validated['description'])){
                $updatedata['description'] = $validated['description'];
            }
            if(isset($validated['image'])){
                $updatedata['image'] = $validated['image'];
            }
            if(isset($validated['thumbnail'])){
                $updatedata['thumbnail'] = $validated['thumbnail'];
            }
            if(isset($validated['parent_id'])){
                $updatedata['parent_id'] = $validated['parent_id'];
            }
            $cat = $category->update($updatedata);
            DB::commit();
            return $category;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ошибка редактирования категории товаров: ' . $e->getMessage());
            return false;
        }
    }
}
