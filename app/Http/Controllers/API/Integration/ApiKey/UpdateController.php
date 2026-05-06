<?php

namespace App\Http\Controllers\API\Integration\ApiKey;

use App\Http\Requests\API\ApiKey\UpdateRequest;
use App\Models\ApiKey;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $id){
        $key = ApiKey::query()->findOrFail($id);
        $validated = $request->validated();
        return $this->service->update($key->id, $validated);
    }
}
