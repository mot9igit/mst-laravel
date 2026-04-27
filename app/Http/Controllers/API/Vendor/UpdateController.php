<?php

namespace App\Http\Controllers\API\Vendor;


use App\Http\Requests\API\Vendor\UpdateRequest;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $vendorId){
        $validated = $request->validated();
        $response = $this->service->update($vendorId, $validated);
        return $response;
    }
}
