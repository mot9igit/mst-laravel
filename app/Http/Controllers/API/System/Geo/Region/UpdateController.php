<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Http\Requests\API\Geo\Region\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $regionId){
        $validated = $request->validated();
        $response = $this->service->update($regionId, $validated);
        return $response;
    }
}
