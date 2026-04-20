<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "name_short",
        "image",
        "thumbnail",
        "address",
        "description",
        "coordinats",
        "city_id",
        "active",
        "integration_type",
        "marketplace",
        "opt_marketplace",
        "version",
        "yml_file",
        "check_remains",
        "check_docs",
        "date_api_ping",
        "date_remains_update",
        "date_docs_update",
        "properties"
    ];

    public function city(): BelongsTo{
        return $this->belongsTo(City::class);
    }

    public function organizations(): BelongsToMany{
        return $this->belongsToMany(Organization::class, 'organization_stores', 'store_id', 'organization_id');
    }
}
