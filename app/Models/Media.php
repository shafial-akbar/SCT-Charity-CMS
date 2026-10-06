<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasUuids;

    protected $fillable = [
        'uploaded_by',

        'file_name',
        'original_name',
        'file_path',
        'disk',
        'mime_type',
        'file_size',

        'alt_text_en',
        'alt_text_bn',

        'title_en',
        'title_bn',

        'caption_en',
        'caption_bn',

        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}