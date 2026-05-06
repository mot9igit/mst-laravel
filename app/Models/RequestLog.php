<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestLog extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'request_logs';
    protected $fillable = [
        "method",
        "url",
        "status_code",
        "duration",
        "ip_address",
        "user_agent",
        "request_body",
        "response_body",
        "error_message",
        "user_id",
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
