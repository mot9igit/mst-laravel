<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreDoc extends Model
{
    protected $table = 'stores_doc';
    protected $fillable = [
        'store_id',
        'number',
        'base_guid',
        'guid',
        'date',
        'description',
        "properties"
    ];
}
