<?php

namespace App\Services\ApiKey;

use App\Repositories\ApiKeyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly ApiKeyRepository $repository
    )
    {}

    public function generate(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return 'ms-' . substr(str_shuffle($chars), 0, random_int(4, 10));
    }

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление api ключа
     *
     * @param int $id
     * @return string
     */
    public function delete(int $id){
        return $this->repository->delete($id);
    }

    /**
     * Создание api ключа
     *
     * @param $validated
     * @return JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $apiKey = $this->repository->create($validated);

        return response()->json([
            'message' => 'Контактное лицо успешно создано',
            'apiKey' => $apiKey
        ], 201);
    }

    /**
     * Обновление api ключа
     *
     * @param int $id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $id, array $validated): JsonResponse
    {
        $city = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Api ключ успешно обновлен',
            'city' => $city
        ], 201);
    }
}
