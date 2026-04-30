<?php

namespace App\Http\Controllers\Admin\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.integration.store.remain.index');
    }
}
