<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRemain extends Model
{
    use HasFactory;

    protected $table = 'stores_remains';

    protected $fillable = [
        'store_id',
        'name',
        'guid',
        'article',
        'product_id',
        'catalog_id',
        'vendor_id',
        'status',
        'catalog_guid',
        'barcode',
        'remains',
        'reserved',
        'available',
        'price',
        'description',
        'tags',
    ];

    public function store(): belongsTo {
        return $this->belongsTo(Store::class);
    }
}
