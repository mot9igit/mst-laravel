<?php


namespace App\Http\Controllers\API\RequestLog;

use App\Http\Controllers\Controller;
use App\Services\RequestLog\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

}
