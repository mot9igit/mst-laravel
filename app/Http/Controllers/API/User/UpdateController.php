<?php

namespace App\Http\Controllers\API\User;

use App\Http\Requests\API\User\UpdateRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, $user){
        $validated = $request->validated();
        $response = $this->service->update($user, $validated);
        return $response;
    }
}
