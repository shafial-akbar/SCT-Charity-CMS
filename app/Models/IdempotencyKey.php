<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class IdempotencyKey extends Model
{
    use HasUuids;

    protected $fillable = [
        'idempotency_key', 'user_id', 'endpoint', 'request_hash',
        'response_status', 'response_body', 'expires_at',
    ];

    protected $casts = [
        'response_body' => 'array',
        'response_status' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
