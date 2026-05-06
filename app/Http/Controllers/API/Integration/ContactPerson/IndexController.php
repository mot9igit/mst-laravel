<?php

namespace App\Http\Controllers\API\Integration\ContactPerson;


use App\Http\Requests\API\ContactPerson\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
