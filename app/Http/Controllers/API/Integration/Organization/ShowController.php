<?php

namespace App\Http\Controllers\API\Integration\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Organization $organization)
    {
        return $organization;
    }
}
