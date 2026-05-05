<?php

namespace App\Http\Controllers\API\ContactPerson;

use App\Http\Requests\API\ContactPerson\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, $user){
        $validated = $request->validated();
        $response = $this->service->update($user, $validated);
        return $response;
    }
}
