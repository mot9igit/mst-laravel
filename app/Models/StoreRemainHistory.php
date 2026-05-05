<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRemainHistory extends Model
{
    use HasFactory;

    protected $table = 'stores_remains_history';

    protected $fillable = [
        'remain_id',
        'date',
        'name',
        'article',
        'remains',
        'reserved',
        'available',
        'price',
    ];

    public function storeRemain(): belongsTo {
        return $this->belongsTo(StoreRemain::class);
    }
}
