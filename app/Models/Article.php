<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Article extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'featured_image_id', 'author_id',
        'status', 'published_at', 'seo_title', 'seo_description',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function featuredImage(): BelongsTo { return $this->belongsTo(Media::class, 'featured_image_id'); }
    public function author(): BelongsTo { return $this->belongsTo(Person::class, 'author_id'); }
}
