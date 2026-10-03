<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasUuids;

    protected $fillable = [
        'program_id', 'title', 'slug', 'short_description', 'description',
        'featured_image_id', 'location', 'start_date', 'end_date', 'status',
        'seo_title', 'seo_description', 'published_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
    ];

    public function program(): BelongsTo { return $this->belongsTo(Program::class); }
    public function featuredImage(): BelongsTo { return $this->belongsTo(Media::class, 'featured_image_id'); }
    public function activities(): HasMany { return $this->hasMany(ProjectActivity::class)->orderBy('sort_order'); }
    public function metrics(): HasMany { return $this->hasMany(ProjectMetric::class)->orderBy('sort_order'); }
    public function budgets(): HasMany { return $this->hasMany(ProjectBudget::class)->orderBy('sort_order'); }
    public function campaigns(): HasMany { return $this->hasMany(Campaign::class); }
}
