<?php

namespace App\Http\Controllers\Admin\Integration\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $organization_id)
    {
        $organization = Organization::findOrFail($organization_id);
        return view('admin.integration.organization.update', compact('organization'));
    }
}
