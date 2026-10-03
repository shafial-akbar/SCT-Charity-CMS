<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Sponsorship extends Model
{
    use HasUuids;

    protected $fillable = [
        'child_id', 'sponsor_name', 'sponsor_email', 'sponsor_phone',
        'amount', 'currency', 'start_date', 'end_date', 'status', 'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function child(): BelongsTo { return $this->belongsTo(SponsoredChild::class, 'child_id'); }
}
