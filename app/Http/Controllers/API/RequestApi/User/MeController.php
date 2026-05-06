<?php

namespace App\Http\Controllers\API\RequestApi\User;

use App\Http\Requests\API\RequestApi\User\MeRequest;
use App\Models\User;

class MeController extends BaseController
{
    public function __invoke(MeRequest $request)
    {
      $user = $request->user();

      return User::find($user->id);
    }
}
