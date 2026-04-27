<?php

namespace App\Http\Controllers\API\Vendor;

use App\Http\Controllers\Controller;
use App\Services\Vendor\Service;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
