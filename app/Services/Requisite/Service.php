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
        return response()->json([
            'message' => 'Реквизиты успешно созданы',
            'requisite' => $requisite
        ], 201);
    }
}
