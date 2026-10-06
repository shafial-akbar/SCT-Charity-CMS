<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasUuids;

    protected $fillable = [
        'category_id','title_en','title_bn','slug_en','slug_bn',
        'description_en','description_bn','cover_image_id','status','published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }

    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_image_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'gallery_id')
            ->orderBy('sort_order', 'asc');
    }
}
