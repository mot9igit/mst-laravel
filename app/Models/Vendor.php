<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "image",
        "thumbnail",
        "description",
        "properties"
    ];

    protected $appends = ['image_url', 'thumb_url'];

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

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_vendors', 'vendor_id', 'organization_id');
    }
}
