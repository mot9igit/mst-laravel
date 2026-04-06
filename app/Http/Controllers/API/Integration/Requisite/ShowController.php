<?php

namespace App\Http\Controllers\API\Integration\Requisite;

use App\Models\Requisite;

class ShowController extends BaseController
{
    public function __invoke(Requisite $requisite)
    {
        return $requisite;
    }
}
