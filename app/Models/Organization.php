<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "image",
        "address",
        "description",
        "bitrix_id",
        "active",
        "verified",
        "properties"
    ];

    public function requisites(): BelongsToMany
    {
        return $this->belongsToMany(Requisite::class, "organization_requisites");
    }

    public function stores(): belongsToMany
    {
        return $this->belongsToMany(Store::class);
    }
}
