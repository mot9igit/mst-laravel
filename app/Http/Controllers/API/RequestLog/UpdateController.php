<?php

namespace App\Http\Controllers\API\RequestLog;

use App\Http\Requests\API\RequestLog\UpdateRequest;
use App\Models\RequestLog;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, int $id){
        $key = RequestLog::query()->findOrFail($id);
        $validated = $request->validated();
        return $this->service->update($key->id, $validated);
    }
}
