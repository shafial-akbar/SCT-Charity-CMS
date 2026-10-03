<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GalleryCategory extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'status'];

    public function galleries(): HasMany { return $this->hasMany(Gallery::class, 'category_id'); }
}
