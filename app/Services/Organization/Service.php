<?php


namespace App\Services\Organization;

use App\Repositories\OrganizationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class Service
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
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
     * @throws \App\Exceptions\UserException
     */
//    public function store($validated)
//    {
//        $user = $this->userRepository->create($validated);
//        return response()->json([
//            'message' => 'Пользователь успешно создан',
//            'user' => $user
//        ], 201);
//    }

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
