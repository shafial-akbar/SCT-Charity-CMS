<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class VideoGallery extends Model
{
    use HasUuids;

    protected $fillable = ['title', 'slug', 'description', 'status', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function videos(): HasMany { return $this->hasMany(Video::class, 'gallery_id')->orderBy('sort_order'); }
}
