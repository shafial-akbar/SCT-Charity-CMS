<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Donation extends Model
{
    use HasUuids;

    protected $fillable = [
        'campaign_id', 'donor_name', 'donor_email', 'donor_phone', 'amount',
        'currency', 'payment_method', 'is_anonymous', 'message', 'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    public function campaign(): BelongsTo { return $this->belongsTo(Campaign::class); }
    public function paymentTransactions(): HasMany { return $this->hasMany(PaymentTransaction::class); }
}
