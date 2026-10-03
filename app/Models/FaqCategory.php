<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FaqCategory extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'status'];

    public function faqs(): HasMany { return $this->hasMany(Faq::class, 'category_id')->orderBy('sort_order'); }
}
