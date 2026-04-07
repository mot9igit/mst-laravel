<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankRequisite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "number",
        "knumber",
        "bik",
        "requisite_id",
        "description",
        "properties"
    ];

    public function requisite(): belongsTo {
        return $this->belongsTo(Requisite::class);
    }
}
