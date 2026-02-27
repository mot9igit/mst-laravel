<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\Profile\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(User $user)
    {
        if ($user->hasMedia('image')){
            $mediaItems = $user->getMedia("*");
            $user->avatar = $mediaItems[0]->getUrl('thumb');
        }
        return $user;
    }
}
