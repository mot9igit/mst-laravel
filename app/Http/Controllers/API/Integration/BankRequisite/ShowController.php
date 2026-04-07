<?php

namespace App\Http\Controllers\API\Integration\BankRequisite;

use App\Http\Controllers\Controller;
use App\Models\BankRequisite;
use App\Models\Organization;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(int $bankrequisite)
    {
        $requisite = BankRequisite::findOrFail($bankrequisite);
        return $requisite;
    }
}
