<?php

namespace App\Services\Requisite;

use App\Models\Requisite;
use App\Repositories\RequisiteRepository;

class Service
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly RequisiteRepository $requisiteRepository,
    )
    {
    }

    public function store($validated)
    {
        $requisite = $this->requisiteRepository->create($validated);
        return response()->json([
            'message' => 'Реквизиты успешно созданы',
            'requisite' => $requisite
        ], 201);
    }
}
