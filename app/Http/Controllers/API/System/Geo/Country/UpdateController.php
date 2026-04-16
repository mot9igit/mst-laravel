<?php

namespace App\Http\Controllers\API\System\Geo\Country;

use App\Http\Requests\API\Geo\Country\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $countryId){
        $validated = $request->validated();
        $response = $this->service->update($countryId, $validated);
        return $response;
    }
}
