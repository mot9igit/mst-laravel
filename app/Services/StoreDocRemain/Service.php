<?php

namespace App\Services\StoreDocRemain;


use App\Models\StoreDocRemain;
use App\Repositories\StoreDocRemainRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly StoreDocRemainRepository $repository
    )
    {}

    public function findById(int $id): StoreDocRemain
    {
        return $this->repository->findById($id);
    }

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Номенклатуры Документа
     *
     * @param int $id
     * @return string
     */
    public function delete(int $id){
        return $this->repository->delete($id);
    }

    /**
     * Создание Номенклатуры Документа
     *
     * @param array $validated
     * @return StoreDocRemain | null
     */
    public function store(array $validated): StoreDocRemain | null
    {
        return $this->repository->create($validated);
    }

    /**
     * Обновление Номенклатуры Документа
     *
     * @param int $id
     * @param array $validated
     * @return StoreDocRemain | null
     */
    public function update(int $id, array $validated): StoreDocRemain | null
    {
        return $this->repository->update($id, $validated);
    }
}
