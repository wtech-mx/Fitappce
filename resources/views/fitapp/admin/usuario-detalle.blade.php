@extends('layouts.fitapp-admin')

@section('title', $user->name.' | FitCoach Admin')

@section('content')
@php
    $statusLabels = [
        'prospect' => ['label' => 'Prospecto', 'class' => ''],
        'active' => ['label' => 'Activo', 'class' => 'blue'],
        'appointment_pending' => ['label' => 'Pendiente de cita', 'class' => 'yellow'],
        'paused' => ['label' => 'Pausado', 'class' => 'red'],
    ];
    $status = $statusLabels[$user->status] ?? $statusLabels['prospect'];
    $nutritionTotals = $activeNutritionPlan?->macroTotals();
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $user->name }}</h1>
        <div class="admin-topbar-subtitle">Expediente visual del usuario: onboarding, planes, nutricion, medidas, pagos y evidencias.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.usuarios.edit', $user) }}" class="btn btn-soft-custom px-4">Editar usuario</a>
        <a href="{{ route('fitapp.admin.usuarios.expediente', $user) }}" class="btn btn-soft-custom px-4">Expediente</a>
        <a href="{{ route('fitapp.admin.planes', ['user' => $user->id]) }}" class="btn btn-primary-custom px-4">Planes</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">
        {{ session('status') }}
    </div>
@endif

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Perfil general</h2>
                        <div class="admin-mini">Datos base para seguimiento.</div>
                    </div>
                    <span class="admin-tag {{ $status['class'] }}">{{ $status['label'] }}</span>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="d-flex gap-3 mb-3">
                    <div class="admin-avatar-lg">{{ $user->initials() }}</div>
                    <div>
                        <div class="admin-card-title">{{ $user->name }}</div>
                        <div class="admin-card-text">{{ $user->email }} - {{ $user->phone ?: 'Sin telefono' }}</div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="admin-tag">{{ $user->service ?: 'Servicio pendiente' }}</span>
                            <span class="admin-tag yellow">{{ $user->plan_type ?: 'Plan pendiente' }}</span>
                            <span class="admin-tag blue">{{ $user->goal ?: 'Objetivo pendiente' }}</span>
                        </div>
                    </div>
                </div>

                <div class="routine-summary-grid">
                    <div><span>Nivel</span><strong>{{ $user->training_level ?: 'Pendiente' }}</strong></div>
                    <div><span>Entrena</span><strong>{{ $user->training_place ?: 'Pendiente' }}</strong></div>
                    <div><span>Frecuencia</span><strong>{{ $user->training_days ? $user->training_days.' dias' : 'Pendiente' }}</strong></div>
                    <div><span>Edad</span><strong>{{ $user->age ? $user->age.' anos' : 'Pendiente' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Planes asignados</h2>
                <div class="admin-mini">Entrenamiento y alimentacion activos.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-exercise-list">
                    <div class="routine-exercise-row">
                        <div class="routine-order"><i class="bi bi-activity"></i></div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">{{ $activeWorkoutPlan?->name ?: ($user->plan_type ?: 'Rutina pendiente de asignar') }}</div>
                                    <div class="admin-mini">{{ $activeWorkoutPlan?->goal ?: ($user->service ?: 'Define el servicio del cliente para vincular una rutina.') }}</div>
                                </div>
                                <a href="{{ $activeWorkoutPlan ? route('fitapp.admin.rutinas.detalle', $activeWorkoutPlan) : route('fitapp.admin.rutinas.crear', ['user' => $user->id]) }}" class="admin-btn-soft">
                                    {{ $activeWorkoutPlan ? 'Ver rutina' : 'Asignar rutina' }}
                                </a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Ejercicios</span><strong>{{ $activeWorkoutPlan ? $activeWorkoutPlan->exerciseCount() : '-' }}</strong></div>
                                <div><span>Dias</span><strong>{{ $activeWorkoutPlan?->days_per_week ?: ($user->training_days ?: '-') }}</strong></div>
                                <div><span>Evidencias</span><strong>{{ $activeWorkoutPlan ? $activeWorkoutPlan->evidenceCount() : '0' }}</strong></div>
                                <div><span>Estado</span><strong>{{ $activeWorkoutPlan ? ($activeWorkoutPlan->status === 'active' ? 'Activo' : ($activeWorkoutPlan->status === 'archived' ? 'Archivado' : 'Borrador')) : $status['label'] }}</strong></div>
                                <div><span>Duracion</span><strong>{{ $activeWorkoutPlan?->duration ?: 'Mensual' }}</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="routine-exercise-row is-superset">
                        <div class="routine-order"><i class="bi bi-cup-hot"></i></div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">{{ $activeNutritionPlan?->name ?: 'Plan alimentario pendiente' }}</div>
                                    <div class="admin-mini">
                                        {{ $activeNutritionPlan ? $activeNutritionPlan->meals->count().' comidas' : ($user->meals_per_day ? $user->meals_per_day.' comidas' : 'Comidas pendientes') }}
                                        - Restriccion: {{ $user->nutrition_restriction ?: 'Ninguna' }}
                                        @if($activeNutritionPlan?->daily_water)
                                            - Agua: {{ $activeNutritionPlan->daily_water }}
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ $activeNutritionPlan ? route('fitapp.admin.nutricion.show', $activeNutritionPlan) : route('fitapp.admin.nutricion.crear', ['user' => $user->id]) }}" class="admin-btn-soft">
                                    {{ $activeNutritionPlan ? 'Ver nutricion' : 'Asignar nutricion' }}
                                </a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Kcal</span><strong>{{ $nutritionTotals ? number_format($nutritionTotals['calories'], 0) : '-' }}</strong></div>
                                <div><span>Proteina</span><strong>{{ $nutritionTotals ? number_format($nutritionTotals['protein'], 1).'g' : '-' }}</strong></div>
                                <div><span>Carbs</span><strong>{{ $nutritionTotals ? number_format($nutritionTotals['carbohydrates'], 1).'g' : '-' }}</strong></div>
                                <div><span>Grasas</span><strong>{{ $nutritionTotals ? number_format($nutritionTotals['fat'], 1).'g' : '-' }}</strong></div>
                                <div><span>Agua</span><strong>{{ $activeNutritionPlan?->daily_water ?: '-' }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Medidas corporales</h2>
                <div class="admin-mini">Registro inicial capturado desde alta de usuario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-summary-grid mb-3">
                    <div><span>Grasa corporal</span><strong>{{ $latestMeasurement?->body_fat ? $latestMeasurement->body_fat.'%' : ($user->initial_body_fat ? $user->initial_body_fat.'%' : '-') }}</strong></div>
                    <div><span>Masa magra</span><strong>{{ $latestMeasurement?->lean_mass ? $latestMeasurement->lean_mass.' kg' : ($user->initial_lean_mass ? $user->initial_lean_mass.' kg' : '-') }}</strong></div>
                    <div><span>Cintura</span><strong>{{ $latestMeasurement?->waist ? $latestMeasurement->waist.' cm' : ($user->initial_waist ? $user->initial_waist.' cm' : '-') }}</strong></div>
                    <div><span>Peso</span><strong>{{ $latestMeasurement?->weight ? $latestMeasurement->weight.' kg' : ($user->initial_weight ? $user->initial_weight.' kg' : '-') }}</strong></div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Medida</th>
                                <th>Valor</th>
                                <th>Meta</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Pecho / torax</td><td>{{ $latestMeasurement?->chest ? $latestMeasurement->chest.' cm' : ($user->initial_chest ? $user->initial_chest.' cm' : '-') }}</td><td>{{ $user->goal_chest ? $user->goal_chest.' cm' : '-' }}</td><td><span class="admin-tag">{{ $latestMeasurement ? 'Actual' : 'Base' }}</span></td></tr>
                            <tr><td>Cadera</td><td>{{ $latestMeasurement?->hip ? $latestMeasurement->hip.' cm' : ($user->initial_hip ? $user->initial_hip.' cm' : '-') }}</td><td>{{ $user->goal_hip ? $user->goal_hip.' cm' : '-' }}</td><td><span class="admin-tag">{{ $latestMeasurement ? 'Actual' : 'Base' }}</span></td></tr>
                            <tr><td>Brazo flexionado</td><td>{{ $latestMeasurement?->arm ? $latestMeasurement->arm.' cm' : ($user->initial_arm ? $user->initial_arm.' cm' : '-') }}</td><td>{{ $user->goal_arm ? $user->goal_arm.' cm' : '-' }}</td><td><span class="admin-tag">{{ $latestMeasurement ? 'Actual' : 'Base' }}</span></td></tr>
                            <tr><td>Muslo</td><td>{{ $latestMeasurement?->thigh ? $latestMeasurement->thigh.' cm' : ($user->initial_thigh ? $user->initial_thigh.' cm' : '-') }}</td><td>{{ $user->goal_thigh ? $user->goal_thigh.' cm' : '-' }}</td><td><span class="admin-tag">{{ $latestMeasurement ? 'Actual' : 'Base' }}</span></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Nueva medicion</a>
                    <a href="{{ route('fitapp.admin.mediciones', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-file-earmark-text"></i> Ver historial</a>
                    <a href="{{ route('fitapp.admin.mediciones.reporte') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Reporte visual</a>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Onboarding</h2>
                <div class="admin-mini">Respuestas iniciales del usuario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item"><div class="admin-list-row"><span>Objetivo</span><strong>{{ $user->goal ?: 'Pendiente' }}</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Servicio</span><strong>{{ $user->service ?: 'Pendiente' }}</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Plan</span><strong>{{ $user->plan_type ?: 'Pendiente' }}</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Restricciones</span><strong>{{ $user->nutrition_restriction ?: 'Ninguna' }}</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Horario dificil</span><strong>{{ $user->difficult_schedule ?: 'Pendiente' }}</strong></div></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Notas medicas</h2>
                <div class="admin-mini">Lesiones, enfermedades o contraindicaciones.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-text-block">
                    {{ $user->medical_notes ?: 'Sin notas medicas capturadas.' }}
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Vista de expediente</div>
            <div class="admin-mini">
                Esta pantalla ya lee datos reales del usuario. Los planes, mediciones historicas, evidencias y pagos se conectaran a este expediente.
            </div>
        </div>
    </div>
</div>
@endsection
