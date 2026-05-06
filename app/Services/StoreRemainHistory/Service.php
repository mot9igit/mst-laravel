<?php

namespace App\Services\StoreRemainHistory;


use App\Repositories\StoreRemainHistoryRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class Service
{
    public function __construct(
        private readonly StoreRemainHistoryRepository $repository
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    /**
     * Удаление Истории
     *
     * @param int $store_id
     * @param int $remain_id
     * @param int $history_id
     * @return string
     */
    public function delete(int $store_id, int $remain_id, int $history_id){
        return $this->repository->delete($history_id);
    }

    /**
     * Создание Истории
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(array $validated): JsonResponse
    {
        $validated['date'] = Carbon::parse($validated['date'])
            ->setTimezone('UTC')
            ->format('Y-m-d H:i:s');
        $history = $this->repository->create($validated);
        return response()->json([
            'message' => 'История успешно создана',
            'history' => $history
        ], 201);
    }

    /**
     * Обновление Истории
     *
     * @param int $store_id
     * @param int $remain_id
     * @param int $history_id
     * @param array $validated
     * @return JsonResponse
     */
    public function update(int $store_id, int $remain_id, int $history_id, array $validated): JsonResponse
    {
        $validated['date'] = Carbon::parse($validated['date'])
            ->setTimezone('UTC')
            ->format('Y-m-d H:i:s');
        $history = $this->repository->update($history_id, $validated);
        return response()->json([
            'message' => 'Цена успешно обновлена',
            'history' => $history
        ], 201);
    }
}
