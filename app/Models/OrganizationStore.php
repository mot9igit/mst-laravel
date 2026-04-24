<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStore extends Model
{

    protected $table = "organization_stores";
    protected $fillable = [
        "organization_id",
        "store_id",
        "dropshipping",
        "description"
    ];
}
