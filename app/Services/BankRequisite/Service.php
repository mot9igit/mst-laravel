<?php

namespace App\Services\BankRequisite;

use App\Repositories\BankRequisiteRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly BankRequisiteRepository $repository,
    )
    {}

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    public function store($validated)
    {
        $requisite = $this->repository->create($validated);
        return response()->json([
            'message' => 'Реквизиты успешно созданы',
            'requisite' => $requisite
        ], 201);
    }

    public function delete(int $requisite_id){
        return $this->repository->delete($requisite_id);
    }

    /**
     * Обновление банковских реквизитов
     *
     * @param $validated
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\UserException
     */
    public function update(int $id, array $validated)
    {
        $requisite = $this->repository->update($id, $validated);
        return response()->json([
            'message' => 'Рекыизиты успешно обновлены',
            'requisite' => $requisite
        ], 201);
    }
}
