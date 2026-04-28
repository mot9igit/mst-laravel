<?php

namespace App\Services\StoreRemainCatalog;


use App\Repositories\StoreRemainCatalogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly StoreRemainCatalogRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Каталога
     *
     * @param int $catalog_id
     * @return string
     */
    public function delete(int $catalog_id){
        return $this->repository->delete($catalog_id);
    }

    /**
     * Создание Каталога
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $catalog = $this->repository->create($validated);
        return response()->json([
            'message' => 'Каталог успешно создан',
            'catalog' => $catalog
        ], 201);
    }

    /**
     * Обновление Каталога
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
    {
        $catalog = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Каталог успешно обновлен',
            'catalog' => $catalog
        ], 201);
    }
}
