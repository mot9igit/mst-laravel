<?php

namespace App\Services\Requisite;

use App\Models\Requisite;
use App\Repositories\RequisiteRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly RequisiteRepository $repository,
    )
    {
    }

    public function get(array $data): LengthAwarePaginator
    {
        return $this->repository->get($data);
    }

    public function store($validated)
    {
        $requisite = $this->repository->create($validated);
        if(isset($validated['org_id'])){
            $requisite->organizations()->attach([$validated['org_id']]);
        }
        return response()->json([
            'message' => 'Реквизиты успешно созданы',
            'requisite' => $requisite
        ], 201);
    }

    public function delete(int $requisite_id){
        return $this->repository->delete($requisite_id);
    }

    /**
     * Обновление организации
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
