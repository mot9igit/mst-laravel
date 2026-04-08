<?php

namespace App\Repositories;

use App\Models\ProductCategory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

class ProductCategoryRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll() : Collection
    {
        $categories = ProductCategory::with('allChildren')
            ->whereNull('parent_id')
            ->published()
            ->get();

        return $categories;
    }
}
