<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'slug', 'description', 'featured_image_id', 'location',
        'start_at', 'end_at', 'registration_url', 'status', 'published_at',
        'seo_title', 'seo_description',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function featuredImage(): BelongsTo { return $this->belongsTo(Media::class, 'featured_image_id'); }
}
