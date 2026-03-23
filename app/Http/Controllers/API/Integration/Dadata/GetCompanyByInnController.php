<?php

namespace App\Http\Controllers\API\Integration\Dadata;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Dadata\getCompanyRequest;
use App\Services\Dadata\Service;
use Illuminate\Http\Request;

class GetCompanyByInnController extends Controller
{
    public function __construct(Service $service){
        $this->service = $service;
    }

    public function __invoke(getCompanyRequest $request){
        $data = $request->validated();
        return $this->service->getCompaniesByInn($data['inn']);
    }
}
