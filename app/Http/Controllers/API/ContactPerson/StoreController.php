<?php

namespace App\Http\Controllers\API\ContactPerson;

use App\Http\Requests\API\ContactPerson\StoreRequest;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request, $user){
        $validated = $request->validated();
        $response = $this->service->update($user, $validated);
        return $response;
    }
}
