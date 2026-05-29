<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'email_verified_at',
    'phone',
    'age',
    'gender',
    'status',
    'goal',
    'service',
    'plan_type',
    'training_level',
    'training_days',
    'training_place',
    'medical_notes',
    'meals_per_day',
    'nutrition_restriction',
    'difficult_schedule',
    'excluded_food_ids',
    'body_visual_type',
    'initial_weight',
    'initial_body_fat',
    'initial_lean_mass',
    'initial_waist',
    'initial_chest',
    'goal_chest',
    'initial_hip',
    'goal_hip',
    'initial_arm',
    'goal_arm',
    'initial_thigh',
    'goal_thigh',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'excluded_food_ids' => 'array',
            'initial_weight' => 'decimal:2',
            'initial_body_fat' => 'decimal:2',
            'initial_lean_mass' => 'decimal:2',
            'initial_waist' => 'decimal:2',
            'initial_chest' => 'decimal:2',
            'goal_chest' => 'decimal:2',
            'initial_hip' => 'decimal:2',
            'goal_hip' => 'decimal:2',
            'initial_arm' => 'decimal:2',
            'goal_arm' => 'decimal:2',
            'initial_thigh' => 'decimal:2',
            'goal_thigh' => 'decimal:2',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function initials(): string
    {
        return collect(explode(' ', trim($this->name)))
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => mb_strtoupper(mb_substr($part, 0, 1)))
            ->join('') ?: 'U';
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(ClientMeasurement::class);
    }

    public function nutritionPlans(): HasMany
    {
        return $this->hasMany(NutritionPlan::class);
    }
}
