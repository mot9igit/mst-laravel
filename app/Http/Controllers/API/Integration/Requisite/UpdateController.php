<?php

namespace App\Http\Controllers\API\Integration\Requisite;

use App\Http\Requests\API\Requisite\UpdateRequest;
use App\Models\Requisite;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Requisite $requisite){
        $requisite_id = $requisite->id;
        $validated = $request->validated();
        $response = $this->service->update($requisite_id, $validated);
        return $response;
    }
}
