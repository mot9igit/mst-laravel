<?php

namespace App\Http\Controllers\API\ProductCategory;

use App\Models\ProductCategory;

class ShowController extends BaseController
{
    public function __invoke(ProductCategory $category)
    {
        return $category;
    }
}
