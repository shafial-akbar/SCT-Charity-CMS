<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectMetric extends Model
{
    use HasUuids;

    protected $table = 'project_metrics';

    protected $fillable = [
        'project_id',
        'metric_name_en',
        'metric_name_bn',
        'metric_value',
        'metric_unit',
        'description_en',
        'description_bn',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}