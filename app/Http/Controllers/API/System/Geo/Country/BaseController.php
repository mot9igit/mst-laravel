<?php

namespace App\Http\Controllers\API\System\Geo\Country;

use App\Http\Controllers\Controller;
use App\Services\Country\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
