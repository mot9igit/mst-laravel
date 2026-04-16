<?php

namespace App\Services\Country;

use App\Repositories\CountryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly CountryRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Страны
     *
     * @param int $organization_id
     * @return string
     */
    public function delete(int $country_id){
        return $this->repository->delete($country_id);
    }

    /**
     * Создание Страны
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $country = $this->repository->create($validated);

        return response()->json([
            'message' => 'Страна успешно создана',
            'country' => $country
        ], 201);
    }

    /**
     * Обновление Страны
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
     */
    public function update(int $id, array $validated)
    {
        $country = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Страна успешно обновлена',
            'organization' => $country
        ], 201);
    }
}
