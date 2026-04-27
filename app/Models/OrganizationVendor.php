<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationVendor extends Model
{
    protected $table = "organization_vendors";
    protected $fillable = [
        "organization_id",
        "vendor_id",
        "description"
    ];
}
