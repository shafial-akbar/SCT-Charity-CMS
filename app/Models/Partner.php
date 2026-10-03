<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Partner extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'slug', 'description', 'logo_id', 'website_url',
        'partner_type', 'sort_order', 'status',
    ];

    public function logo(): BelongsTo { return $this->belongsTo(Media::class, 'logo_id'); }
}
