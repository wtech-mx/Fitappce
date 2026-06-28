@extends('layouts.fitapp-admin')

@section('title', 'Expediente de '.$user->name.' | FitCoach Admin')

@section('content')
@php
    $lastAppointment = $user->appointments
        ->where('kind', 'appointment')
        ->whereNotIn('status', ['cancelled'])
        ->sortByDesc('starts_at')
        ->first();
    $upcomingAppointments = $user->appointments
        ->where('kind', 'appointment')
        ->whereNotIn('status', ['cancelled', 'completed'])
        ->sortBy('starts_at')
        ->take(4);
    $fakeMeasurements = [
        ['date' => '29/05/2026', 'type' => 'Seguimiento mensual', 'weight' => '80.0 kg', 'fat' => '20.0%', 'waist' => '61.5 cm', 'note' => 'Baja ligera de cintura, mantener cardio suave.'],
        ['date' => '29/04/2026', 'type' => 'Ajuste de plan', 'weight' => '82.4 kg', 'fat' => '21.4%', 'waist' => '64.0 cm', 'note' => 'Mejor adherencia entre semana; fin de semana irregular.'],
        ['date' => '29/03/2026', 'type' => 'Valoracion inicial', 'weight' => '84.1 kg', 'fat' => '23.0%', 'waist' => '68.0 cm', 'note' => 'Arranque con deficit moderado y tecnica base.'],
    ];
    $fakeRoutineHistory = [
        ['name' => $activeWorkoutPlan?->name ?: 'Fuerza base mensual', 'date' => 'Mayo 2026', 'focus' => $activeWorkoutPlan?->goal ?: 'Espalda, pierna y core', 'status' => 'Activa'],
        ['name' => 'Acondicionamiento tecnico', 'date' => 'Abril 2026', 'focus' => 'Tecnica, rango de movimiento y habitos', 'status' => 'Archivada'],
        ['name' => 'Arranque 4 semanas', 'date' => 'Marzo 2026', 'focus' => 'Adaptacion, control de cargas y movilidad', 'status' => 'Archivada'],
    ];
    $fakeNutritionHistory = [
        ['name' => $activeNutritionPlan?->name ?: 'Plan personalizado actual', 'date' => 'Mayo 2026', 'kcal' => $nutritionTotals ? number_format($nutritionTotals['calories'], 0).' kcal' : '2100 kcal', 'status' => 'Activo'],
        ['name' => 'Deficit progresivo', 'date' => 'Abril 2026', 'kcal' => '1950 kcal', 'status' => 'Archivado'],
        ['name' => 'Base de adherencia', 'date' => 'Marzo 2026', 'kcal' => '2050 kcal', 'status' => 'Archivado'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Expediente de {{ $user->name }}</h1>
        <div class="admin-topbar-subtitle">Mesa de consulta para revisar historial, capturar avances y sugerir la siguiente cita.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios.detalle', $user) }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Perfil</a>
        <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="btn btn-primary-custom px-4"><i class="bi bi-plus-circle me-1"></i> Nueva medicion</a>
        <div class="admin-avatar">{{ $user->initials() }}</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">
        {{ $errors->first() }}
    </div>
@endif

<div class="record-hero mb-4">
    <div>
        <span class="record-kicker"><i class="bi bi-folder2-open"></i> Expediente clinico-deportivo</span>
        <h2>{{ $user->goal ?: 'Objetivo pendiente' }}</h2>
        <p>{{ $user->service ?: 'Servicio pendiente' }} · {{ $user->training_days ? $user->training_days.' dias de entrenamiento' : 'Frecuencia pendiente' }} · {{ $user->nutrition_restriction ?: 'Sin restriccion alimentaria' }}</p>
    </div>
    <div class="record-hero-stats">
        <div><span>Ultima cita</span><strong>{{ $lastAppointment ? $lastAppointment->starts_at->format('d/m') : 'Sin cita' }}</strong></div>
        <div><span>Siguiente ideal</span><strong>{{ $nextFollowUp->format('d/m') }}</strong></div>
        <div><span>Adherencia</span><strong>86%</strong></div>
    </div>
</div>

<div class="record-layout">
    <div class="record-main">
        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Resumen para la cita</h2>
                        <div class="admin-mini">Datos clave antes de decidir ajustes.</div>
                    </div>
                    <span class="admin-tag blue">Consulta actual</span>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-summary-grid">
                    <div class="record-metric">
                        <span>Peso actual</span>
                        <strong>{{ $latestMeasurement?->weight ? $latestMeasurement->weight.' kg' : ($user->initial_weight ? $user->initial_weight.' kg' : '80.0 kg') }}</strong>
                        <small>-2.4 kg vs mes anterior</small>
                    </div>
                    <div class="record-metric">
                        <span>Grasa corporal</span>
                        <strong>{{ $latestMeasurement?->body_fat ? $latestMeasurement->body_fat.'%' : ($user->initial_body_fat ? $user->initial_body_fat.'%' : '20.0%') }}</strong>
                        <small>Meta: 18%</small>
                    </div>
                    <div class="record-metric">
                        <span>Cintura</span>
                        <strong>{{ $latestMeasurement?->waist ? $latestMeasurement->waist.' cm' : ($user->initial_waist ? $user->initial_waist.' cm' : '61.5 cm') }}</strong>
                        <small>-2.5 cm</small>
                    </div>
                    <div class="record-metric">
                        <span>Plan kcal</span>
                        <strong>{{ $nutritionTotals ? number_format($nutritionTotals['calories'], 0) : '2100' }}</strong>
                        <small>{{ $activeNutritionPlan?->daily_water ?: '2 litros agua' }}</small>
                    </div>
                </div>

                <div class="record-consult-box mt-3">
                    <div>
                        <div class="fw-bold mb-1">Decision sugerida para hoy</div>
                        <div class="admin-mini">Mantener calorias, subir 1 serie en pierna y agendar seguimiento dentro de 4 semanas.</div>
                    </div>
                    <button class="admin-btn-soft" type="button"><i class="bi bi-magic"></i> Preparar ajuste</button>
                </div>
            </div>
        </section>

        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Historial del cliente</h2>
                        <div class="admin-mini">Rutinas, planes alimentarios y mediciones anteriores en una sola vista.</div>
                    </div>
                    <div class="record-tabs" role="group" aria-label="Secciones del expediente">
                        <button class="active" type="button" data-record-tab="rutinas">Rutinas</button>
                        <button type="button" data-record-tab="nutricion">Nutricion</button>
                        <button type="button" data-record-tab="medidas">Medidas</button>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-tab-panel active" data-record-panel="rutinas">
                    <div class="record-timeline">
                        @foreach ($fakeRoutineHistory as $routine)
                            <div class="record-timeline-item">
                                <div class="record-dot"></div>
                                <div class="record-history-card">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-bold">{{ $routine['name'] }}</div>
                                            <div class="admin-mini">{{ $routine['date'] }} · {{ $routine['focus'] }}</div>
                                        </div>
                                        <span class="admin-tag {{ $routine['status'] === 'Activa' ? 'blue' : '' }}">{{ $routine['status'] }}</span>
                                    </div>
                                    <div class="record-history-actions">
                                        <a href="{{ $activeWorkoutPlan ? route('fitapp.admin.rutinas.detalle', $activeWorkoutPlan) : route('fitapp.admin.rutinas.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver rutina</a>
                                        <button type="button" class="admin-btn-soft"><i class="bi bi-clipboard-check"></i> Usar como base</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="record-tab-panel" data-record-panel="nutricion">
                    <div class="record-timeline">
                        @foreach ($fakeNutritionHistory as $plan)
                            <div class="record-timeline-item">
                                <div class="record-dot food"></div>
                                <div class="record-history-card">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-bold">{{ $plan['name'] }}</div>
                                            <div class="admin-mini">{{ $plan['date'] }} · {{ $plan['kcal'] }}</div>
                                        </div>
                                        <span class="admin-tag {{ $plan['status'] === 'Activo' ? 'blue' : '' }}">{{ $plan['status'] }}</span>
                                    </div>
                                    <div class="record-history-actions">
                                        <a href="{{ $activeNutritionPlan ? route('fitapp.admin.nutricion.show', $activeNutritionPlan) : route('fitapp.admin.nutricion.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-cup-hot"></i> Ver plan</a>
                                        <button type="button" class="admin-btn-soft"><i class="bi bi-pencil"></i> Ajustar macros</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="record-tab-panel" data-record-panel="medidas">
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Peso</th>
                                    <th>Grasa</th>
                                    <th>Cintura</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fakeMeasurements as $measurement)
                                    <tr>
                                        <td>{{ $measurement['date'] }}</td>
                                        <td>{{ $measurement['type'] }}</td>
                                        <td>{{ $measurement['weight'] }}</td>
                                        <td>{{ $measurement['fat'] }}</td>
                                        <td>{{ $measurement['waist'] }}</td>
                                        <td>{{ $measurement['note'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Capturar nueva medicion</a>
                        <a href="{{ route('fitapp.admin.mediciones', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-clock-history"></i> Historial completo</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <aside class="record-side">
        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Agendar siguiente cita</h2>
                <div class="admin-mini">Sugerencia a un mes de la consulta actual.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-calendar-card mb-3">
                    <div>
                        <span>Fecha recomendada</span>
                        <strong>{{ $nextFollowUp->translatedFormat('d M Y') }}</strong>
                    </div>
                    <i class="bi bi-calendar2-check"></i>
                </div>

                <div class="record-slot-list">
                    @foreach ($fakeAppointments as $appointment)
                        <button type="button" class="record-slot {{ $appointment['class'] === 'red' ? 'blocked' : '' }}">
                            <span>
                                <strong>{{ $appointment['date'] }} · {{ $appointment['time'] }}</strong>
                                <small>{{ $appointment['title'] }}</small>
                            </span>
                            <em class="{{ $appointment['class'] }}">{{ $appointment['status'] }}</em>
                        </button>
                    @endforeach
                </div>

                <div class="admin-card-actions">
                    <button class="btn btn-primary-custom flex-fill" type="button"><i class="bi bi-calendar-plus me-1"></i> Agendar</button>
                    <button class="admin-btn-soft" type="button"><i class="bi bi-slash-circle"></i> Bloquear</button>
                </div>
            </div>
        </section>

        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Notas de consulta</h2>
                <div class="admin-mini">Borrador visual para capturar acuerdos.</div>
            </div>
            <div class="admin-form-card-body">
                <textarea class="form-control input-soft record-note-area" rows="6">Cliente reporta buen descanso, hambre controlada y molestia leve en rodilla izquierda. Revisar tecnica de sentadilla y ajustar volumen.</textarea>
                <div class="admin-card-actions">
                    <button class="admin-btn-soft" type="button"><i class="bi bi-save"></i> Guardar nota</button>
                    <button class="admin-btn-soft" type="button"><i class="bi bi-send"></i> Enviar resumen</button>
                </div>
            </div>
        </section>

        <section class="admin-helper-note">
            <div class="fw-bold mb-1">Propuesta de flujo</div>
            <div class="admin-mini">
                Desde aqui el coach revisa el historial, captura medidas, agenda la siguiente cita y bloquea horarios sin salir del cliente.
            </div>
        </section>
    </aside>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-record-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.recordTab;

                document.querySelectorAll('[data-record-tab]').forEach((button) => button.classList.toggle('active', button === tab));
                document.querySelectorAll('[data-record-panel]').forEach((panel) => panel.classList.toggle('active', panel.dataset.recordPanel === target));
            });
        });
    });
</script>
@endpush
