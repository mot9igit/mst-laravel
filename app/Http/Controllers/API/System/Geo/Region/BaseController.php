<?php

namespace App\Http\Controllers\API\System\Geo\Region;

use App\Http\Controllers\Controller;
use App\Services\Region\Service;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
