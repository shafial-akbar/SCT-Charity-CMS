<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Campaign extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id', 'program_id', 'title', 'slug', 'short_description',
        'description', 'featured_image_id', 'target_amount', 'currency',
        'start_date', 'end_date', 'status', 'is_featured', 'seo_title',
        'seo_description', 'published_at',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function program(): BelongsTo { return $this->belongsTo(Program::class); }
    public function featuredImage(): BelongsTo { return $this->belongsTo(Media::class, 'featured_image_id'); }
    public function donations(): HasMany { return $this->hasMany(Donation::class); }
}
