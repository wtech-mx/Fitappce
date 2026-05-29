<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'name',
    'plan_date',
    'goal',
    'level',
    'place',
    'days_per_week',
    'duration',
    'status',
    'notes',
])]
class WorkoutPlan extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(WorkoutPlanDay::class)->orderBy('sort_order');
    }

    public function exerciseCount(): int
    {
        if ($this->relationLoaded('days')) {
            return (int) $this->days->sum(fn (WorkoutPlanDay $day) => $day->exercises->count());
        }

        return (int) $this->days()->withCount('exercises')->get()->sum('exercises_count');
    }

    public function evidenceCount(): int
    {
        if ($this->relationLoaded('days')) {
            return (int) $this->days->sum(fn (WorkoutPlanDay $day) => $day->exercises->where('requires_evidence', true)->count());
        }

        return (int) $this->days()
            ->with(['exercises' => fn ($query) => $query->where('requires_evidence', true)])
            ->get()
            ->sum(fn (WorkoutPlanDay $day) => $day->exercises->count());
    }
}
