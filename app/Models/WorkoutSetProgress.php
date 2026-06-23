<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'workout_plan_day_id',
    'progress_key',
    'progress_date',
    'completed_sets',
    'rest_started_at',
    'completed_at',
])]
class WorkoutSetProgress extends Model
{
    protected $table = 'workout_set_progress';

    protected function casts(): array
    {
        return [
            'progress_date' => 'date',
            'completed_sets' => 'integer',
            'rest_started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function day(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlanDay::class, 'workout_plan_day_id');
    }
}
