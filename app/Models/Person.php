<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Person extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'designation', 'biography', 'photo_id', 'email', 'phone',
        'social_links', 'sort_order', 'status',
    ];

    protected $casts = ['social_links' => 'array'];

    public function photo(): BelongsTo { return $this->belongsTo(Media::class, 'photo_id'); }
    public function articles(): HasMany { return $this->hasMany(Article::class, 'author_id'); }
    public function news(): HasMany { return $this->hasMany(News::class, 'author_id'); }
}
