<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\IndexRequest;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
