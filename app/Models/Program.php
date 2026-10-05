<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasUuids;

    protected $fillable = [
        'title_en',
        'title_bn',
        'slug_en',
        'slug_bn',
        'short_description_en',
        'short_description_bn',
        'description_en',
        'description_bn',
        'featured_image_id',
        'status',
        'sort_order',
        'seo_title_en',
        'seo_title_bn',
        'seo_description_en',
        'seo_description_bn',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }
}
