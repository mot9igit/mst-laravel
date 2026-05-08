<?php

namespace App\Http\Controllers\API\Integration\Store\Doc\Remain;

use App\Http\Controllers\Controller;
use App\Services\StoreDocRemain\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
