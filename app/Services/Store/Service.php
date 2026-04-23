<?php

namespace App\Services\Store;

use App\Repositories\StoreRepository;
use App\Services\Tools\FileUploaderService;
use App\Services\Tools\ThumbService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly storeRepository $repository,
        private readonly FileUploaderService $fileUploaderService,
        private readonly ThumbService $thumbService,
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Точки Продаж
     *
     * @param int $store_id
     * @return string
     */
    public function delete(int $store_id){
        return $this->repository->delete($store_id);
    }

    /**
     * Создание Точки Продаж
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
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
        $store = $this->repository->create($validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $store_id = $store->id;
            $newpath = "stores/{$store_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $store->image = $path;
            $store->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $store->save();
        }
        return response()->json([
            'message' => 'Точка Продаж успешно создана',
            'store' => $store
        ], 201);
    }

    /**
     * Обновление Точки Продаж
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
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
        $store = $this->repository->update($id, $validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $store_id = $store->id;
            $response_file = $this->fileUploaderService->delete("stores/{$store_id}/");
            $newpath = "stores/{$store_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $store->image = $path;
            $store->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $store->save();
        }
        return response()->json([
            'message' => 'Точка Продаж успешно обновлена',
            'store' => $store
        ], 201);
    }
}
