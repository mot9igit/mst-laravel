<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreDocRemain extends Model
{
    protected $table = 'stores_doc_remain';

    protected $fillable = [
        'guid',
        'doc_id',
        'remain_id',
        'type',
        'article',
        'count',
        'price',
        'description',
        "properties",
    ];
}
