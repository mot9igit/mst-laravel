<?php


namespace App\Services\Organization;

use App\Repositories\OrganizationRepository;
use App\Repositories\RequisiteRepository;
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
     * Создание пользователя
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {

        $organization = $this->organizationRepository->create($validated);
        $requisite = $this->requisiteRepository->create($validated);
        $organization->requisites()->attach([$requisite->id]);
        return response()->json([
            'message' => 'Организация успешно создана',
            'organization' => $organization
        ], 201);
    }

    /**
     * Обновление пользователя
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
     */
//    public function update(int $id, array $validated)
//    {
//        $user = $this->userRepository->update($id, $validated);
//        return response()->json([
//            'message' => 'Пользователь успешно обновлен',
//            'user' => $user
//        ], 201);
//    }
}
