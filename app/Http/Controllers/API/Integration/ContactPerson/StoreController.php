<?php

namespace App\Http\Controllers\API\Integration\ContactPerson;

use App\Http\Requests\API\ContactPerson\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request){
        $validated = $request->validated();
        return $this->service->store($validated);
    }
}
