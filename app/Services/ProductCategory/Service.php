<?php

namespace App\Services\ProductCategory;

use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use App\Services\Tools\FileUploaderService;
use App\Services\Tools\ThumbService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class Service
{
    public function __construct(
        private readonly ProductCategoryRepository $repository,
        private readonly FileUploaderService $fileUploaderService,
        private readonly ThumbService $thumbService,
    )
    {}

    public function get($validated) : Collection | LengthAwarePaginator
    {
        if(isset($validated['tree'])) {
            if($validated['tree'] == 1){
                return $this->repository->getAll();
            }
        }
        return $this->repository->get($validated);
    }

    /**
     * Удаление Категории
     *
     * @param int $category_id
     * @return string
     */
    public function delete(int $category_id){
        return $this->repository->delete($category_id);
    }

    /**
     * Создание категории
     *
     * @param array $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $image = null;
        if(isset($validated['files'])){
            if(is_array($validated['files'])){
                $image = $validated['files'][0];
            }else {
                $image = $validated['files'];
            }
            unset($validated['files']);
        }
        $validated['slug'] = Str::slug($validated['title']);
        $category = $this->repository->create($validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $cat_id = $category->id;
            $newpath = "category/{$cat_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $category->image = $path;
            $category->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $category->save();
        }
        return response()->json([
            'message' => 'Категория успешно создана',
            'category' => $category
        ], 201);
    }

    /**
     * Обновление Категории
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated)
    {
        $image = null;
        if(isset($validated['files'])){
            if(is_array($validated['files'])){
                $image = $validated['files'][0];
            }else {
                $image = $validated['files'];
            }
            unset($validated['files']);
        }
        $category = $this->repository->update($id, $validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $category_id = $category->id;
            $response_file = $this->fileUploaderService->delete("category/{$category_id}/");
            $newpath = "category/{$category_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $category->image = $path;
            $category->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $category->save();
        }
        return response()->json([
            'message' => 'Организация успешно обновлена',
            'category' => $category
        ], 201);
    }
}
