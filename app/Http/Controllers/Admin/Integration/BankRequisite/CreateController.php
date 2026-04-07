<?php

namespace App\Http\Controllers\Admin\Integration\BankRequisite;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $organization = Organization::findOrFail($request->route('organization'));
        $requisite = Requisite::findOrFail($request->route('requisite'));
        return view('admin.integration.bank-requisite.create', compact('organization', 'requisite'));
    }
}
