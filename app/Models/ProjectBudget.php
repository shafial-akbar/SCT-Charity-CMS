<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectBudget extends Model
{
    use HasUuids;

    protected $table = 'project_budgets';

    protected $fillable = [
        'project_id',
        'category_en',
        'category_bn',
        'description_en',
        'description_bn',
        'allocated_amount',
        'spent_amount',
        'currency',
        'sort_order',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}