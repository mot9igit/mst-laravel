<?php

namespace App\Http\Controllers\Admin\Integration\Store\Remain;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreRemain;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(int $remain_id)
    {
        $remain = StoreRemain::findOrFail($remain_id);
        return view('admin.integration.store.remain.update', compact('remain'));
    }
}
