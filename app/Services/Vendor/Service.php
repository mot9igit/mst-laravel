<?php

namespace App\Services\Vendor;

use App\Repositories\VendorRepository;
use App\Services\Tools\FileUploaderService;
use App\Services\Tools\ThumbService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly VendorRepository $repository,
        private readonly FileUploaderService $fileUploaderService,
        private readonly ThumbService $thumbService,
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Бренда
     *
     * @param int $vendor_id
     * @return string
     */
    public function delete(int $vendor_id){
        return $this->repository->delete($vendor_id);
    }

    /**
     * Создание Бренда
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
        $vendor = $this->repository->create($validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $vendor_id = $vendor->id;
            $newpath = "vendors/{$vendor_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $vendor->image = $path;
            $vendor->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $vendor->save();
        }
        return response()->json([
            'message' => 'Бренд успешно создан',
            'organization' => $vendor
        ], 201);
    }

    /**
     * Обновление Бренда
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
        $vendor = $this->repository->update($id, $validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $vendor_id = $vendor->id;
            $response_file = $this->fileUploaderService->delete("vendors/{$vendor_id}/");
            $newpath = "vendors/{$vendor_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $vendor->image = $path;
            $vendor->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $vendor->save();
        }
        return response()->json([
            'message' => 'Бренд успешно обновлен',
            'vendor' => $vendor
        ], 201);
    }
}
