<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Organization extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'organizations';
    protected $appends = ['image_url', 'thumb_url'];

    protected $fillable = [
        "name",
        "image",
        "thumbnail",
        "address",
        "description",
        "bitrix_id",
        "active",
        "verified",
        "properties"
    ];

    protected $casts = [
        "properties" => "array",
        "active" => "boolean",
        "verified" => "boolean",
        "image" => "string",
        "thumbnail" => "string",
    ];

    public function requisites(): BelongsToMany
    {
        return $this->belongsToMany(Requisite::class, "organization_requisites");
    }

    public function stores(): belongsToMany
    {
        return $this->belongsToMany(Store::class);
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
            if (env('FILESYSTEM_DISK', 'public') === 'tws3') {
                return Storage::disk('tws3')->url($this->thumbnail);
            }
            return asset('storage/' . $this->thumbnail);
        }else{
            return null;
        }
    }
}
