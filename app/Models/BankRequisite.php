<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankRequisite extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "number",
        "knumber",
        "bik",
        "requisite_id",
        "properties"
    ];

    public function requisite(): belongsTo {
        return $this->belongsTo(Requisite::class);
    }
}
