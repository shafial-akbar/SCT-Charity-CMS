<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ContactSubmission extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status',
        'admin_notes', 'handled_by', 'handled_at',
    ];

    protected $casts = ['handled_at' => 'datetime'];

    public function handler(): BelongsTo { return $this->belongsTo(User::class, 'handled_by'); }
}
