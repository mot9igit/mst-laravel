<?php

namespace App\Http\Controllers\API\System\Geo\City;
use App\Http\Requests\API\Geo\City\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $cityId){
        $validated = $request->validated();
        $response = $this->service->update($cityId, $validated);
        return $response;
    }
}
