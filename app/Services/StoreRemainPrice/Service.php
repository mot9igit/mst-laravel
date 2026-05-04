<?php

namespace App\Services\StoreRemainPrice;


use App\Repositories\StoreRemainCatalogRepository;
use App\Repositories\StoreRemainPriceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly StoreRemainPriceRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Каталога
     *
     * @param int $store_id
     * @param int $remain_id
     * @param int $price_id
     * @return string
     */
    public function delete(int $store_id, int $remain_id, int $price_id){
        return $this->repository->delete($price_id);
    }

    /**
     * Создание Цены
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $price = $this->repository->create($validated);
        return response()->json([
            'message' => 'Цена успешно создана',
            'price' => $price
        ], 201);
    }

    /**
     * Обновление Цены
     *
     * @param int $store_id
     * @param int $remain_id
     * @param int $price_id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $store_id, int $remain_id, int $price_id, array $validated): JsonResponse
    {
        $price = $this->repository->update($price_id, $validated);
        return response()->json([
            'message' => 'Цена успешно обновлена',
            'price' => $price
        ], 201);
    }
}
