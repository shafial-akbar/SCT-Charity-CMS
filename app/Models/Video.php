<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Video extends Model
{
    use HasUuids;

    protected $fillable = [
        'gallery_id', 'title', 'slug', 'description', 'video_provider',
        'video_url', 'video_id', 'thumbnail_id', 'published_at', 'status', 'sort_order',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function gallery(): BelongsTo { return $this->belongsTo(VideoGallery::class, 'gallery_id'); }
    public function thumbnail(): BelongsTo { return $this->belongsTo(Media::class, 'thumbnail_id'); }
}
