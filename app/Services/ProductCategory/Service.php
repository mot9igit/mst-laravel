<?php

namespace App\Services\ProductCategory;

use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class Service
{
    public function __construct(
        private readonly ProductCategoryRepository $repository,
    )
    {}

    public function getAll() : Collection
    {
        return $this->repository->getAll();
    }
}
