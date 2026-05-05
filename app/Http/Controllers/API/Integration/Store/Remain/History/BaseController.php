<?php

namespace App\Http\Controllers\API\Integration\Store\Remain\History;

use App\Http\Controllers\Controller;
use App\Services\StoreRemainHistory\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
