<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            ['name' => 'Hip Thrust', 'parent_category' => 'Tren inferior', 'category' => 'Gluteo', 'subcategory' => 'Hip Thrust', 'level' => 'Intermedio', 'primary_muscle' => 'Gluteo mayor', 'description' => 'Ejercicio base para desarrollo de gluteo y extension de cadera.', 'purpose' => 'Trabaja gluteo mayor, fuerza de cadera y potencia.', 'coach_notes' => 'Empuja desde talones y bloquea cadera arriba sin arquear espalda.'],
            ['name' => 'Sentadilla con barra', 'parent_category' => 'Tren inferior', 'category' => 'Pierna', 'subcategory' => 'Cuadriceps', 'level' => 'Intermedio', 'primary_muscle' => 'Cuadriceps', 'description' => 'Ejercicio base para fuerza de pierna completa.', 'purpose' => 'Desarrolla piernas, core y estabilidad.', 'coach_notes' => 'Mantén pecho arriba y rodillas alineadas con pies.'],
            ['name' => 'Prensa de piernas', 'parent_category' => 'Tren inferior', 'category' => 'Pierna', 'subcategory' => 'Maquinas', 'level' => 'Principiante', 'primary_muscle' => 'Cuadriceps', 'description' => 'Trabajo controlado de pierna en maquina.', 'purpose' => 'Permite acumular volumen de piernas con mayor estabilidad.'],
            ['name' => 'Zancadas', 'parent_category' => 'Tren inferior', 'category' => 'Pierna', 'subcategory' => 'Unilateral', 'level' => 'Intermedio', 'primary_muscle' => 'Gluteo y cuadriceps', 'description' => 'Trabajo unilateral para fuerza y equilibrio.', 'purpose' => 'Mejora estabilidad, control y fuerza por pierna.'],
            ['name' => 'Remo con mancuerna', 'parent_category' => 'Tren superior', 'category' => 'Espalda', 'subcategory' => 'Remos', 'level' => 'Intermedio', 'primary_muscle' => 'Dorsal', 'description' => 'Remo unilateral para espalda.', 'purpose' => 'Trabaja dorsal, romboides y control escapular.'],
            ['name' => 'Jalon en polea alta', 'parent_category' => 'Tren superior', 'category' => 'Espalda', 'subcategory' => 'Jalones', 'level' => 'Principiante', 'primary_muscle' => 'Dorsal', 'description' => 'Jalon vertical para espalda.', 'purpose' => 'Fortalece dorsales y mejora patron de traccion.'],
        ];

        foreach ($exercises as $exercise) {
            Exercise::updateOrCreate(
                ['name' => $exercise['name']],
                $exercise + ['demo_type' => 'video', 'allows_evidence' => true, 'is_active' => true]
            );
        }
    }
}
