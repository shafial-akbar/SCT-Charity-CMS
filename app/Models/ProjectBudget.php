<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectBudget extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id', 'category', 'description', 'allocated_amount',
        'spent_amount', 'currency', 'sort_order',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
