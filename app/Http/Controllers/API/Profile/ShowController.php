<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(User $user)
    {
        if ($user->hasMedia('image')){
            $user->avatar = $user->getFirstMediaUrl('image','thumb');
        }
        return $user;
    }
}
