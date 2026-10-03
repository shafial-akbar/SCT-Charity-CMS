<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SponsoredChild extends Model
{
    use HasUuids;

    protected $table = 'sponsored_children';

    protected $fillable = [
        'child_code', 'display_name', 'age', 'gender', 'short_bio',
        'photo_id', 'location', 'status',
    ];

    protected $casts = ['age' => 'integer'];

    public function photo(): BelongsTo { return $this->belongsTo(Media::class, 'photo_id'); }
    public function sponsorships(): HasMany { return $this->hasMany(Sponsorship::class, 'child_id'); }
}
