<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use HasUuids;

    protected $fillable = [
        'gallery_id',
        'media_id',
        'caption_en',
        'caption_bn',
        'alt_text_en',
        'alt_text_bn',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
