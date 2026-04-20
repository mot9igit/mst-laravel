<?php

namespace App\Services\City;

use App\Repositories\CityRepository;
use App\Repositories\CountryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly CityRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Города
     *
     * @param int $city_id
     * @return string
     */
    public function delete(int $city_id){
        return $this->repository->delete($city_id);
    }

    /**
     * Создание Города
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $city = $this->repository->create($validated);

        return response()->json([
            'message' => 'Город успешно создан',
            'city' => $city
        ], 201);
    }

    /**
     * Обновление Города
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
    {
        $city = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Город успешно обновлен',
            'city' => $city
        ], 201);
    }
}
