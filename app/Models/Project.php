<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasUuids;

    protected $fillable = [
        'program_id',

        // Bilingual title & slug
        'title_en',
        'title_bn',
        'slug_en',
        'slug_bn',

        // Bilingual descriptions
        'short_description_en',
        'short_description_bn',
        'description_en',
        'description_bn',

        // Featured image
        'featured_image_id',

        // Bilingual location
        'location_en',
        'location_bn',

        // Project dates & status
        'start_date',
        'end_date',
        'status',

        // Bilingual SEO
        'seo_title_en',
        'seo_title_bn',
        'seo_description_en',
        'seo_description_bn',

        // Publishing
        'published_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ProjectActivity::class)
            ->orderBy('sort_order');
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(ProjectMetric::class)
            ->orderBy('sort_order');
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(ProjectBudget::class)
            ->orderBy('sort_order');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }
}