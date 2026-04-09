<?php

namespace App\Http\Controllers\Admin\Products\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Category\UpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $category = ProductCategory::findOrFail($request->route('category'));
        return view('admin.product.category.update', compact('category'));
    }
}
