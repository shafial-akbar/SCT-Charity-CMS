<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class VolunteerApplication extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'occupation', 'skills',
        'interests', 'message', 'status', 'admin_notes', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = ['reviewed_at' => 'datetime'];

    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by'); }
}
