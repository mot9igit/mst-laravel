<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['image_url', 'thumb_url'];

    protected $fillable = [
        "name",
        "name_short",
        "image",
        "thumbnail",
        "address",
        "description",
        "coordinates",
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

    public function getImageUrlAttribute(): string | null
    {
        if($this->image) {
            if (env('FILESYSTEM_DISK', 'public') === 'tws3') {
                return Storage::disk('tws3')->url($this->image);
            }
            return asset('storage/' . $this->image);
        }else{
            return null;
        }
    }

    public function getThumbUrlAttribute(): string | null
    {
        if($this->image) {
            if (Config::get('filesystems.default') === 'tws3') {
                return Storage::disk('tws3')->url($this->thumbnail);
            }
            return asset('storage/' . $this->thumbnail);
        }else{
            return null;
        }
    }
}
