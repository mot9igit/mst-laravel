<?php

namespace App\Services\StoreDoc;


use App\Repositories\StoreDocRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly StoreDocRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Документа
     *
     * @param int $store_id
     * @param int $doc_id
     * @return string
     */
    public function delete(int $store_id, int $doc_id){
        return $this->repository->delete($doc_id);
    }

    /**
     * Создание Документа
     *
     * @param array $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $doc = $this->repository->create($validated);
        return response()->json([
            'message' => 'Документ успешно создан',
            'doc' => $doc
        ], 201);
    }

    /**
     * Обновление Документа
     *
     * @param int $store_id
     * @param int $doc_id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $store_id, int $doc_id, array $validated): JsonResponse
    {
        $doc = $this->repository->update($doc_id, $validated);
        return response()->json([
            'message' => 'Документ успешно обновлен',
            'doc' => $doc
        ], 201);
    }
}
