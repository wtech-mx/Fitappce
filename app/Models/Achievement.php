<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'category',
    'goal_text',
    'trigger_type',
    'target_count',
    'target_unit',
    'image_path',
    'is_active',
])]
class Achievement extends Model
{
    protected function casts(): array
    {
        return [
            'target_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function clientAchievements(): HasMany
    {
        return $this->hasMany(ClientAchievement::class);
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset($this->image_path) : null;
    }

    public function categoryLabel(): string
    {
        return self::categoryOptions()[$this->category] ?? 'General';
    }

    public function triggerLabel(): string
    {
        return self::triggerOptions()[$this->trigger_type] ?? 'Manual';
    }

    public static function categoryOptions(): array
    {
        return [
            'habits' => 'Constancia y habitos',
            'nutrition' => 'Nutricion y cocina',
            'performance' => 'Fuerza y rendimiento',
            'transformation' => 'Evolucion fisica',
            'custom' => 'Personalizado',
        ];
    }

    public static function triggerOptions(): array
    {
        return [
            'diet_or_routine_streak' => 'Dieta o rutina por racha',
            'diet_streak' => 'Dieta registrada por racha',
            'routine_streak' => 'Rutina completada por racha',
            'water_streak' => 'Agua diaria por racha',
            'routine_month_complete' => 'Rutinas del mes completadas',
            'meal_photo_week' => 'Fotos de comidas por semana',
            'produce_days' => 'Verduras/frutas por dias',
            'strength_record' => 'Record de carga superado',
            'heavy_workout' => 'Rutina pesada completada',
            'measurement_progress' => 'Progreso notable en medidas',
            'platform_months' => 'Meses en plataforma',
            'manual' => 'Desbloqueo manual',
        ];
    }
}
