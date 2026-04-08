<?php

namespace App\Http\Controllers\API\ProductCategory;

use App\Http\Controllers\Controller;
use App\Services\ProductCategory\Service;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
