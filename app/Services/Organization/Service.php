<?php


namespace App\Services\Organization;

use App\Repositories\OrganizationRepository;
use App\Repositories\RequisiteRepository;
use App\Services\Tools\FileUploaderService;
use App\Services\Tools\ThumbService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class Service
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
        private readonly RequisiteRepository $requisiteRepository,
        private readonly FileUploaderService $fileUploaderService,
        private readonly ThumbService $thumbService,
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->organizationRepository->get($data);
    }

    /**
     * Удаление Организации
     *
     * @param int $organization_id
     * @return string
     */
    public function delete(int $organization_id){
        return $this->organizationRepository->delete($organization_id);
    }

    /**
     * Создание Организации
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
        $organization = $this->organizationRepository->create($validated);
        $requisite = $this->requisiteRepository->create($validated);
        $organization->requisites()->attach([$requisite->id]);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $org_id = $organization->id;
            $newpath = "organizations/{$org_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $organization->image = $path;
            $organization->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $organization->save();
        }
        return response()->json([
            'message' => 'Организация успешно создана',
            'organization' => $organization
        ], 201);
    }

    /**
     * Обновление организации
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
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
        $organization = $this->organizationRepository->update($id, $validated);
        if($image){
            // картинка во временном хранилище -> перемещаем
            $org_id = $organization->id;
            $response_file = $this->fileUploaderService->delete("organizations/{$org_id}/");
            $newpath = "organizations/{$org_id}/";
            $path = $this->fileUploaderService->moveUploadFile($image, $newpath);
            $organization->image = $path;
            $organization->thumbnail = $this->thumbService->createQuadThumb($path, 200);
            $organization->save();
        }
        return response()->json([
            'message' => 'Организация успешно обновлена',
            'organization' => $organization
        ], 201);
    }

    public function getUsers($data): LengthAwarePaginator
    {
        return $this->organizationRepository->getUsers($data);
    }

    public function storeUser(array $validated): JsonResponse
    {
        return $this->organizationRepository->storeUser($validated);
    }

    public function deleteUser(int $organization_id, int $user_id): JsonResponse
    {
        return $this->organizationRepository->deleteUser($organization_id, $user_id);
    }

    public function getStores($data): LengthAwarePaginator
    {
        return $this->organizationRepository->getStores($data);
    }

    public function storeStore(array $validated): JsonResponse
    {
        return $this->organizationRepository->storeStore($validated);
    }

    public function deleteStore(int $organization_id, int $store_id): JsonResponse
    {
        return $this->organizationRepository->deleteStore($organization_id, $store_id);
    }
}
