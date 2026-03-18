<?php

namespace App\Http\Controllers\Admin\Integration\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('admin.integration.organization.create');
    }
}
