<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SiteSetting extends Model
{
    use HasUuids;

    protected $fillable = [
        'setting_key', 'setting_value', 'setting_type', 'is_public',
    ];

    protected $casts = ['is_public' => 'boolean'];
}
