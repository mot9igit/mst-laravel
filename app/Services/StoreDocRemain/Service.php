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
     * @param int $store_id
     * @param int $doc_remain_id
     * @return string
     */
    public function delete(int $store_id, int $doc_remain_id){
        return $this->repository->delete($doc_remain_id);
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
     * @param int $store_id
     * @param int $doc_remain_id
     * @param array $validated
     * @return StoreDocRemain | null
     */
    public function update(int $store_id, int $doc_remain_id, array $validated): StoreDocRemain | null
    {
        return $this->repository->update($doc_remain_id, $validated);
    }
}
