<?php

namespace App\Http\Controllers\API\Integration\Dadata;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Dadata\getAddressRequest;
use App\Services\Dadata\Service;
use Illuminate\Http\Request;

class GetAddressController extends Controller
{
    public function __construct(Service $service){
        $this->service = $service;
    }

    public function __invoke(getAddressRequest $request){
        $data = $request->validated();
        return $this->service->getAddress($data['query']);
    }
}
