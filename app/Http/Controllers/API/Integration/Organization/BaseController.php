<?php

namespace App\Http\Controllers\API\Integration\Organization;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Services\Organization\Service;
use App\Services\Requisite\Service as RequisiteService;
use Illuminate\Http\Request;

#[AllowDynamicProperties]
class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service, RequisiteService $requisiteService)
    {
        $this->service = $service;
        $this->requisiteService = $requisiteService;
    }
}
