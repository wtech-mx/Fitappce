<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['workout_plan_id', 'day_name', 'focus', 'estimated_time', 'sort_order'])]
class WorkoutPlanDay extends Model
{
    public function workoutPlan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(WorkoutPlanExercise::class)->orderBy('sort_order');
    }
}
