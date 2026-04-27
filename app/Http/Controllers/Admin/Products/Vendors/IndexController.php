<?php

namespace App\Http\Controllers\Admin\Products\Vendors;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view("admin.product.vendor.index");
    }
}
