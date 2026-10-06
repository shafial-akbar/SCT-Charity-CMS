<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    use HasUuids;

    protected $table = 'gallery_categories';

    protected $fillable = [
        'name_en','name_bn','slug_en','slug_bn',
        'description_en','description_bn','sort_order','status',
    ];

    protected $casts = ['sort_order' => 'integer'];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'category_id');
    }
}
