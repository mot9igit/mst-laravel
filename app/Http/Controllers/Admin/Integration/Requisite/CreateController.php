<?php

namespace App\Http\Controllers\Admin\Integration\Requisite;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $organization = Organization::findOrFail($request->route('organization'));
        return view('admin.integration.requisite.create', compact('organization'));
    }
}
