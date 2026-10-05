<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use HasUuids;

    protected $fillable = [
        'page_id',
        'section_type',

        'title_en',
        'title_bn',

        'subtitle_en',
        'subtitle_bn',

        'content_en',
        'content_bn',

        'media_id',
        'data',

        'sort_order',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}