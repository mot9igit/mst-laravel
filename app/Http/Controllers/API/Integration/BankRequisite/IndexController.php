<?php

namespace App\Http\Controllers\API\Integration\BankRequisite;

use App\Http\Requests\API\BankRequisite\IndexRequest;

class IndexController extends BaseController
{
    public function __invoke(IndexRequest $request)
    {
        $validated = $request->validated();
        return $this->service->get($validated);
    }
}
