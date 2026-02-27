<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($user)
    {
        $user = User::findOrFail($user);
        return view('admin.user.update', compact('user'));
    }
}
