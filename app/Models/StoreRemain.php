<?php

namespace App\Models;

use App\Enums\StoreRemainStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StoreRemain extends Model
{
    use HasFactory;

    protected $table = 'stores_remains';

    protected $casts = [
        'status' => StoreRemainStatus::class,
    ];

    protected $fillable = [
        'store_id',
        'name',
        'guid',
        'article',
        'product_id',
        'parent_id',
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
        'published',
        'brand_manual',
        'article_manual',
        'tags',
    ];

    public function store(): belongsTo {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(ProductCategory::class, 'id', 'parent_id');
    }

    public function category(): HasOne {
        return $this->hasOne(StoreRemainCatalog::class, 'id', 'catalog_id');
    }

    public function vendor(): HasOne {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
