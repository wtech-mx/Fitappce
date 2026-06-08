<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['name' => 'Fuego Interior', 'category' => 'habits', 'goal_text' => 'Registrar la dieta o marcar la rutina completada por 7 dias seguidos.', 'trigger_type' => 'diet_or_routine_streak', 'target_count' => 7, 'target_unit' => 'dias seguidos'],
            ['name' => 'Tsunami Saludable', 'category' => 'habits', 'goal_text' => 'Cumplir con el objetivo de agua diario durante 2 semanas seguidas.', 'trigger_type' => 'water_streak', 'target_count' => 14, 'target_unit' => 'dias seguidos'],
            ['name' => 'Asistencia Perfecta', 'category' => 'habits', 'goal_text' => 'Completar todas las rutinas asignadas del primer mes.', 'trigger_type' => 'routine_month_complete', 'target_count' => 1, 'target_unit' => 'mes completo'],
            ['name' => 'Chef con Estrella', 'category' => 'nutrition', 'goal_text' => 'Subir fotos de todas tus comidas durante una semana completa.', 'trigger_type' => 'meal_photo_week', 'target_count' => 7, 'target_unit' => 'dias'],
            ['name' => 'Vitamina Pura', 'category' => 'nutrition', 'goal_text' => 'Alcanzar la meta de porciones de verduras/frutas durante 10 dias.', 'trigger_type' => 'produce_days', 'target_count' => 10, 'target_unit' => 'dias'],
            ['name' => 'Rompiendo Barreras', 'category' => 'performance', 'goal_text' => 'Superar tu record de peso en cualquier ejercicio respecto a la semana anterior.', 'trigger_type' => 'strength_record', 'target_count' => 1, 'target_unit' => 'record'],
            ['name' => 'Inquebrantable', 'category' => 'performance', 'goal_text' => 'Completar un entrenamiento de pierna o una rutina catalogada como pesada por el coach.', 'trigger_type' => 'heavy_workout', 'target_count' => 1, 'target_unit' => 'rutina pesada'],
            ['name' => 'Metamorfosis', 'category' => 'transformation', 'goal_text' => 'Primer mes completado con cambios notables en las medidas.', 'trigger_type' => 'measurement_progress', 'target_count' => 1, 'target_unit' => 'mes'],
            ['name' => 'Version 2.0', 'category' => 'transformation', 'goal_text' => 'Llegar a los 3 meses en la plataforma con progreso constante.', 'trigger_type' => 'platform_months', 'target_count' => 3, 'target_unit' => 'meses'],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['name' => $achievement['name']],
                $achievement + ['is_active' => true]
            );
        }
    }
}
