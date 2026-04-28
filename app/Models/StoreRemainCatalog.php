<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreRemainCatalog extends Model
{
    use HasFactory;

    protected $table = 'stores_remains_catalogs';

    protected $fillable = [
        'store_id',
        'name',
        'guid',
        'parent_guid',
        'name_alt',
        'parent_id',
        'description',
        'active',
        'properties',
    ];

    public function store(): belongsTo {
        return $this->belongsTo(Store::class);
    }
}
