<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'workout_plan_day_id',
    'exercise_id',
    'name',
    'block_type',
    'sets',
    'reps',
    'rest',
    'tempo',
    'requires_evidence',
    'notes',
    'sort_order',
])]
class WorkoutPlanExercise extends Model
{
    public function day(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlanDay::class, 'workout_plan_day_id');
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
