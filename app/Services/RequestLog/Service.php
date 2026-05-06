<?php

namespace App\Services\RequestLog;

use App\Repositories\RequestLogRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly RequestLogRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление лога
     *
     * @param int $id
     * @return string
     */
    public function delete(int $id){
        return $this->repository->delete($id);
    }

    /**
     * Создание лога
     *
     * @param $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $log = $this->repository->create($validated);

        return response()->json([
            'message' => 'Лог успешно создан',
            'log' => $log
        ], 201);
    }

    /**
     * Обновление лога
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
    {
        $log = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Лог успешно обновлен',
            'log' => $log
        ], 201);
    }
}
