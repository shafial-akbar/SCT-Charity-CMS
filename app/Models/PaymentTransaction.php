<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentTransaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'donation_id', 'gateway', 'transaction_id', 'gateway_transaction_id',
        'payment_method', 'amount', 'currency', 'status', 'gateway_response', 'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function donation(): BelongsTo { return $this->belongsTo(Donation::class); }
}
