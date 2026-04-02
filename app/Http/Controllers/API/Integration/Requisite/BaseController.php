<?php

namespace App\Http\Controllers\API\Integration\Requisite;

use App\Http\Controllers\Controller;
use App\Services\Requisite\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
