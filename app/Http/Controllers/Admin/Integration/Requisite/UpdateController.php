<?php

namespace App\Http\Controllers\Admin\Integration\Requisite;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $organization = Organization::findOrFail($request->route('organization'));
        $requisite = Requisite::findOrFail($request->route('requisite'));
        return view('admin.integration.requisite.update', compact('organization', 'requisite'));
    }
}
