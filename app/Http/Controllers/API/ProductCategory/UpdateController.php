<?php

namespace App\Http\Controllers\API\ProductCategory;

use App\Http\Requests\API\ProductCategory\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $category){
        $validated = $request->validated();
        $response = $this->service->update($category, $validated);
        return $response;
    }
}
