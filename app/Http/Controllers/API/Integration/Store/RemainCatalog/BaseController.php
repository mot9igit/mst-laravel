<?php

namespace App\Http\Controllers\API\Integration\Store\RemainCatalog;

use App\Http\Controllers\Controller;
use App\Services\StoreRemainCatalog\Service;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
