<?php

namespace App\Services\Region;

use App\Repositories\CityRepository;
use App\Repositories\RegionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly RegionRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Региона
     *
     * @param int $region_id
     * @return string
     */
    public function delete(int $region_id){
        return $this->repository->delete($region_id);
    }

    /**
     * Создание Города
     *
     * @param array $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $region = $this->repository->create($validated);

        return response()->json([
            'message' => 'Город успешно создан',
            'region' => $region
        ], 201);
    }

    /**
     * Обновление Региона
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated)
    {
        $region = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Регион успешно обновлен',
            'region' => $region
        ], 201);
    }
}
