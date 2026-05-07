<?php

namespace App\Http\Controllers\API\Integration\Store\Doc;

use App\Http\Controllers\Controller;
use App\Services\StoreDoc\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
