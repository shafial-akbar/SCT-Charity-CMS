<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Faq extends Model
{
    use HasUuids;

    protected $fillable = ['category_id', 'question', 'answer', 'sort_order', 'status'];

    public function category(): BelongsTo { return $this->belongsTo(FaqCategory::class, 'category_id'); }
}
