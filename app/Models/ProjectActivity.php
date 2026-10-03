<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectActivity extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id', 'title', 'description', 'activity_date',
        'location', 'status', 'sort_order',
    ];

    protected $casts = ['activity_date' => 'date'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
