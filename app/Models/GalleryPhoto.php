<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GalleryPhoto extends Model
{
    use HasUuids;

    protected $fillable = ['gallery_id', 'media_id', 'caption', 'alt_text', 'sort_order'];

    public function gallery(): BelongsTo { return $this->belongsTo(Gallery::class); }
    public function media(): BelongsTo { return $this->belongsTo(Media::class); }
}
