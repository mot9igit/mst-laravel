<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\Price;

use App\Http\Controllers\Controller;
use App\Services\StoreRemainPrice\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
