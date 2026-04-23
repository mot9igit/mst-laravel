<?php

namespace App\Http\Controllers\API\Integration\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(int $cityId)
    {
        return Store::findOrFail($cityId)->with('city')->firstOrFail();
    }
}
