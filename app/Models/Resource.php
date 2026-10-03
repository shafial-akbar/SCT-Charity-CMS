<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Resource extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'slug', 'description', 'resource_type', 'file_id',
        'publication_date', 'status', 'seo_title', 'seo_description',
    ];

    protected $casts = ['publication_date' => 'date'];

    public function file(): BelongsTo { return $this->belongsTo(Media::class, 'file_id'); }
}
