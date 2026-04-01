<?php

namespace App\Http\Controllers\API\Integration\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Organization\UpdateRequest;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $organization){
        $validated = $request->validated();
        $response = $this->service->update($organization, $validated);
        return $response;
    }
}
