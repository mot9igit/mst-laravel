<?php

namespace App\Http\Controllers\Admin\Integration\BankRequisite;

use App\Http\Controllers\Controller;
use App\Models\BankRequisite;
use App\Models\Organization;
use App\Models\Requisite;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $organization = Organization::findOrFail($request->route('organization'));
        $requisite = Requisite::findOrFail($request->route('requisite'));
        $bank_requisite = BankRequisite::findOrFail($request->route('bankrequisite'));
        return view('admin.integration.bank-requisite.update', compact('organization', 'requisite', 'bank_requisite'));
    }
}
