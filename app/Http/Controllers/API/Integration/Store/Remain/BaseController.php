<?php

namespace App\Http\Controllers\API\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Services\StoreRemain\Service;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
