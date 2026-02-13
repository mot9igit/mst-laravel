<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('front.profile.index');
    }
}
