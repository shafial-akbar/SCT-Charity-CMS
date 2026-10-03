<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Program extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'featured_image_id',
        'status', 'sort_order', 'seo_title', 'seo_description', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}
