<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectMetric extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id', 'metric_name', 'metric_value', 'metric_unit',
        'description', 'sort_order',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
