<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRemainPrice extends Model
{
    use HasFactory;

    protected $table = 'stores_remains_prices';

    protected $fillable = [
        'remain_id',
        'name',
        'guid',
        'price',
        'active',
        'description',
    ];

    public function storeRemain(): belongsTo {
        return $this->belongsTo(StoreRemain::class);
    }
}
