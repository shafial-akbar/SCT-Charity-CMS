<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Navigation extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'status'];

    public function items(): HasMany
    {
        return $this->hasMany(NavigationItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }

    public function allItems(): HasMany
    {
        return $this->hasMany(NavigationItem::class)->orderBy('sort_order');
    }
}
