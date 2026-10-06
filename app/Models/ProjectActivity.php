<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectActivity extends Model
{
    use HasUuids;

    protected $table = 'project_activities';

    protected $fillable = [
        'project_id',
        'title_en',
        'title_bn',
        'description_en',
        'description_bn',
        'activity_date',
        'location_en',
        'location_bn',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
