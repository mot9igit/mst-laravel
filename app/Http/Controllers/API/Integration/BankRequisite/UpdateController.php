<?php

namespace App\Http\Controllers\API\Integration\BankRequisite;

use App\Http\Requests\API\BankRequisite\UpdateRequest;
use App\Models\BankRequisite;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $bankrequisite){
        $requisite = BankRequisite::findOrFail($bankrequisite);
        $requisite_id = $requisite->id;
        $validated = $request->validated();
        $response = $this->service->update($requisite_id, $validated);
        return $response;
    }
}
