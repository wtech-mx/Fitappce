@extends('layouts.fitapp-admin')

@section('title', 'Expediente de '.$user->name.' | FitCoach Admin')

@section('content')
@php
    $nextAppointment = $user->appointments
        ->where('kind', 'appointment')
        ->whereNotIn('status', ['cancelled'])
        ->filter(fn ($appointment) => $appointment->starts_at->isFuture())
        ->sortBy('starts_at')
        ->first();
    $lastAppointment = $user->appointments
        ->where('kind', 'appointment')
        ->whereNotIn('status', ['cancelled'])
        ->filter(fn ($appointment) => $appointment->starts_at->isPast())
        ->sortByDesc('starts_at')
        ->first();
    $upcomingAppointments = $user->appointments
        ->where('kind', 'appointment')
        ->whereNotIn('status', ['cancelled', 'completed'])
        ->sortBy('starts_at')
        ->take(4);
    $measurementRows = $user->measurements;
    $routineHistory = $user->workoutPlans->take(5);
    $nutritionHistory = $user->nutritionPlans->take(5);
    $photoAlbums = $user->progressPhotos
        ->groupBy(fn ($photo) => $photo->created_at->format('Y-m'))
        ->map(function ($photos, $key) {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $key)->startOfMonth();

            return [
                'key' => $key,
                'label' => $date->translatedFormat('F Y'),
                'date' => $date,
                'photos' => $photos->values(),
                'count' => $photos->count(),
                'appointment' => $photos->first()?->appointment,
            ];
        })
        ->sortByDesc(fn ($album) => $album['date']->timestamp);
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Expediente de {{ $user->name }}</h1>
        <div class="admin-topbar-subtitle">Mesa de consulta para revisar historial, capturar avances y agendar la siguiente cita.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios.detalle', $user) }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Perfil</a>
        <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="btn btn-primary-custom px-4"><i class="bi bi-plus-circle me-1"></i> Nueva medicion</a>
        <div class="admin-avatar">{{ $user->initials() }}</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<div class="record-hero mb-4">
    <div>
        <span class="record-kicker"><i class="bi bi-folder2-open"></i> Expediente clinico-deportivo</span>
        <h2>{{ $user->goal ?: 'Objetivo pendiente' }}</h2>
        <p>{{ $user->service ?: 'Servicio pendiente' }} · {{ $user->training_days ? $user->training_days.' dias de entrenamiento' : 'Frecuencia pendiente' }} · {{ $user->nutrition_restriction ?: 'Sin restriccion alimentaria' }}</p>
    </div>
    <div class="record-hero-stats">
        <div>
            <span>{{ $nextAppointment ? 'Proxima cita' : 'Ultima cita' }}</span>
            <strong>{{ $nextAppointment ? $nextAppointment->starts_at->format('d/m') : ($lastAppointment ? $lastAppointment->starts_at->format('d/m') : 'Sin cita') }}</strong>
        </div>
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
                    <span class="admin-tag blue">Consulta</span>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-summary-grid">
                    <div class="record-metric">
                        <span>Peso actual</span>
                        <strong>{{ $latestMeasurement?->weight ? $latestMeasurement->weight.' kg' : ($user->initial_weight ? $user->initial_weight.' kg' : '-') }}</strong>
                        <small>Ultima medicion</small>
                    </div>
                    <div class="record-metric">
                        <span>Grasa corporal</span>
                        <strong>{{ $latestMeasurement?->body_fat ? $latestMeasurement->body_fat.'%' : ($user->initial_body_fat ? $user->initial_body_fat.'%' : '-') }}</strong>
                        <small>Seguimiento mensual</small>
                    </div>
                    <div class="record-metric">
                        <span>Cintura</span>
                        <strong>{{ $latestMeasurement?->waist ? $latestMeasurement->waist.' cm' : ($user->initial_waist ? $user->initial_waist.' cm' : '-') }}</strong>
                        <small>Perimetro principal</small>
                    </div>
                    <div class="record-metric">
                        <span>Plan kcal</span>
                        <strong>{{ $nutritionTotals ? number_format($nutritionTotals['calories'], 0) : '-' }}</strong>
                        <small>{{ $activeNutritionPlan?->daily_water ?: 'Agua pendiente' }}</small>
                    </div>
                </div>

                <div class="record-consult-box mt-3">
                    <div>
                        <div class="fw-bold mb-1">Decision sugerida para hoy</div>
                        <div class="admin-mini">Revisar adherencia, capturar nuevas medidas y agendar seguimiento dentro de 4 semanas.</div>
                    </div>
                    <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-clipboard2-pulse"></i> Capturar avances</a>
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
                        <button type="button" data-record-tab="fotos">Fotos</button>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-tab-panel active" data-record-panel="rutinas">
                    <div class="record-timeline">
                        @forelse ($routineHistory as $routine)
                            <div class="record-timeline-item">
                                <div class="record-dot"></div>
                                <div class="record-history-card">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-bold">{{ $routine->name }}</div>
                                            <div class="admin-mini">{{ $routine->plan_date?->format('d/m/Y') ?: 'Sin fecha' }} · {{ $routine->goal ?: 'Objetivo pendiente' }}</div>
                                        </div>
                                        <span class="admin-tag {{ $routine->status === 'active' ? 'blue' : '' }}">{{ $routine->status === 'active' ? 'Activa' : 'Archivada' }}</span>
                                    </div>
                                    <div class="record-history-actions">
                                        <a href="{{ route('fitapp.admin.rutinas.detalle', $routine) }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver rutina</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="admin-helper-note">Aun no hay rutinas para este cliente.</div>
                        @endforelse
                    </div>
                </div>

                <div class="record-tab-panel" data-record-panel="nutricion">
                    <div class="record-timeline">
                        @forelse ($nutritionHistory as $plan)
                            @php $totals = $plan->macroTotals(); @endphp
                            <div class="record-timeline-item">
                                <div class="record-dot food"></div>
                                <div class="record-history-card">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="fw-bold">{{ $plan->name }}</div>
                                            <div class="admin-mini">{{ $plan->plan_date?->format('d/m/Y') ?: 'Sin fecha' }} · {{ number_format($totals['calories'], 0) }} kcal</div>
                                        </div>
                                        <span class="admin-tag {{ $plan->status === 'active' ? 'blue' : '' }}">{{ $plan->status === 'active' ? 'Activo' : 'Archivado' }}</span>
                                    </div>
                                    <div class="record-history-actions">
                                        <a href="{{ route('fitapp.admin.nutricion.show', $plan) }}" class="admin-btn-soft"><i class="bi bi-cup-hot"></i> Ver plan</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="admin-helper-note">Aun no hay planes alimentarios para este cliente.</div>
                        @endforelse
                    </div>
                </div>

                <div class="record-tab-panel" data-record-panel="medidas">
                    <div class="measurement-history-list">
                        @forelse ($measurementRows as $measurement)
                            <div class="measurement-accordion-item">
                                <button type="button" class="measurement-accordion-head" data-measurement-toggle>
                                    <span>
                                        <strong>{{ $measurement->measured_at->format('d/m/Y') }}</strong>
                                        <small>{{ $measurement->appointment_type }} · {{ $measurement->weight ? $measurement->weight.' kg' : 'Peso pendiente' }} · {{ $measurement->body_fat ? $measurement->body_fat.'% grasa' : 'Grasa pendiente' }}</small>
                                    </span>
                                    <em>Desglosar <i class="bi bi-chevron-down"></i></em>
                                </button>

                                <div class="measurement-accordion-body">
                                    <div class="measurement-detail-grid">
                                        <div><span>Peso</span><strong>{{ $measurement->weight ? $measurement->weight.' kg' : '-' }}</strong></div>
                                        <div><span>Grasa corporal</span><strong>{{ $measurement->body_fat ? $measurement->body_fat.'%' : '-' }}</strong></div>
                                        <div><span>Masa magra</span><strong>{{ $measurement->lean_mass ? $measurement->lean_mass.' kg' : '-' }}</strong></div>
                                        <div><span>Masa grasa</span><strong>{{ $measurement->fat_mass ? $measurement->fat_mass.' kg' : '-' }}</strong></div>
                                        <div><span>Cintura</span><strong>{{ $measurement->waist ? $measurement->waist.' cm' : '-' }}</strong></div>
                                        <div><span>Torax</span><strong>{{ $measurement->chest ? $measurement->chest.' cm' : '-' }}</strong></div>
                                        <div><span>Cadera</span><strong>{{ $measurement->hip ? $measurement->hip.' cm' : '-' }}</strong></div>
                                        <div><span>Brazo</span><strong>{{ $measurement->arm ? $measurement->arm.' cm' : '-' }}</strong></div>
                                        <div><span>Muslo</span><strong>{{ $measurement->thigh ? $measurement->thigh.' cm' : '-' }}</strong></div>
                                        <div><span>Pantorrilla</span><strong>{{ $measurement->calf ? $measurement->calf.' cm' : '-' }}</strong></div>
                                        <div><span>Meta grasa</span><strong>{{ $measurement->target_body_fat ? $measurement->target_body_fat.'%' : '-' }}</strong></div>
                                        <div><span>Meta peso</span><strong>{{ $measurement->target_weight ? $measurement->target_weight.' kg' : '-' }}</strong></div>
                                    </div>
                                    <div class="admin-helper-note mt-3">
                                        <div class="fw-bold mb-1">Notas del coach</div>
                                        <div class="admin-mini">{{ $measurement->notes ?: 'Sin notas para esta medicion.' }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="admin-helper-note">Aun no hay mediciones registradas.</div>
                        @endforelse
                    </div>
                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Capturar nueva medicion</a>
                        <a href="{{ route('fitapp.admin.mediciones', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-clock-history"></i> Historial completo</a>
                    </div>
                </div>

                <div class="record-tab-panel" data-record-panel="fotos">
                    @if($photoAlbums->isEmpty())
                        <div class="admin-helper-note">
                            <div class="fw-bold mb-1">Sin fotos enviadas</div>
                            <div class="admin-mini">Cuando el cliente suba sus avances, aqui se formaran albums mensuales para revisar y comparar.</div>
                        </div>
                    @else
                        <div class="photo-album-toolbar">
                            <div>
                                <div class="fw-bold">Albums de progreso</div>
                                <div class="admin-mini">Abre un mes para ver sus fotos o marca dos albums para compararlos lado a lado.</div>
                            </div>
                            <span class="admin-tag blue">{{ $user->progressPhotos->count() }} fotos</span>
                        </div>

                        <div class="photo-album-grid">
                            @foreach($photoAlbums as $album)
                                <button type="button" class="photo-album-card" data-album-toggle="{{ $album['key'] }}" data-album-title="{{ ucfirst($album['label']) }}">
                                    <span class="photo-album-icon"><i class="bi bi-folder2-open"></i></span>
                                    <span class="photo-album-copy">
                                        <strong>{{ ucfirst($album['label']) }}</strong>
                                        <small>{{ $album['count'] }} foto{{ $album['count'] === 1 ? '' : 's' }}{{ $album['appointment']?->starts_at ? ' - Cita '.$album['appointment']->starts_at->format('d/m/Y') : '' }}</small>
                                    </span>
                                    <span class="photo-album-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $album['key'] }}" data-compare-album aria-label="Comparar album {{ $album['label'] }}">
                                    </span>
                                </button>
                            @endforeach
                        </div>

                        @foreach($photoAlbums as $album)
                            <div class="photo-album-panel" data-album-panel="{{ $album['key'] }}">
                                <div class="photo-album-panel-head">
                                    <div>
                                        <strong>{{ ucfirst($album['label']) }}</strong>
                                        <span>{{ $album['count'] }} foto{{ $album['count'] === 1 ? '' : 's' }} de progreso</span>
                                    </div>
                                    <em>{{ $album['appointment']?->starts_at ? 'Cita '.$album['appointment']->starts_at->format('d/m/Y') : 'Sin cita vinculada' }}</em>
                                </div>
                                <div class="admin-progress-photo-grid">
                                    @foreach($album['photos'] as $photo)
                                        <a href="{{ $photo->imageUrl() }}" target="_blank" class="admin-progress-photo-card">
                                            <img src="{{ $photo->imageUrl() }}" alt="Foto de progreso">
                                            <span>
                                                <strong>{{ $photo->created_at->format('d/m/Y') }}</strong>
                                                <small>{{ $photo->appointment?->starts_at?->format('d/m/Y') ? 'Cita '.$photo->appointment->starts_at->format('d/m/Y') : 'Sin cita vinculada' }} - {{ $photo->savedPercent() }}% menos peso</small>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="photo-compare-panel d-none" data-photo-compare-panel>
                            <div class="photo-compare-head">
                                <div>
                                    <strong>Comparativo de albums</strong>
                                    <span>Selecciona dos meses para revisar cambios visuales.</span>
                                </div>
                                <button type="button" class="admin-btn-soft" data-clear-photo-compare><i class="bi bi-x-circle"></i> Limpiar</button>
                            </div>
                            <div class="photo-compare-grid">
                                <div class="photo-compare-column" data-compare-column="left"></div>
                                <div class="photo-compare-column" data-compare-column="right"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <aside class="record-side">
        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Nueva cita</h2>
                <div class="admin-mini">Agenda un seguimiento para este cliente y evita empalmes.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="record-calendar-card mb-3">
                    <div>
                        <span>Fecha recomendada</span>
                        <strong>{{ $nextFollowUp->translatedFormat('d M Y') }}</strong>
                    </div>
                    <i class="bi bi-calendar2-check"></i>
                </div>

                <form method="POST" action="{{ route('fitapp.admin.citas.store') }}" class="record-appointment-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="redirect_to" value="{{ url()->current() }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo de cita</label>
                        <select name="appointment_type" class="form-select input-soft" required>
                            <option value="Seguimiento mensual">Seguimiento mensual</option>
                            <option value="Valoracion inicial">Valoracion inicial</option>
                            <option value="Renovacion de plan">Renovacion de plan</option>
                            <option value="Revision tecnica">Revision tecnica</option>
                        </select>
                    </div>

                    <div class="row g-2">
                        <div class="col-7">
                            <label class="form-label fw-bold">Fecha</label>
                            <input type="date" name="appointment_date" class="form-control input-soft" value="{{ old('appointment_date', $nextFollowUp->toDateString()) }}" required data-appointment-date>
                        </div>
                        <div class="col-5">
                            <label class="form-label fw-bold">Hora</label>
                            <input type="time" name="appointment_time" class="form-control input-soft" value="{{ old('appointment_time', '10:00') }}" required data-appointment-time>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="form-label fw-bold">Duracion</label>
                            <select name="duration_minutes" class="form-select input-soft">
                                <option value="30">30 min</option>
                                <option value="45" selected>45 min</option>
                                <option value="60">60 min</option>
                                <option value="90">90 min</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Modalidad</label>
                            <select name="modality" class="form-select input-soft">
                                <option>Presencial</option>
                                <option>Online</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mt-1">
                        <div class="col-6">
                            <label class="form-label fw-bold">Pago</label>
                            <select name="payment_method" class="form-select input-soft">
                                <option value="">Pendiente</option>
                                <option>Efectivo</option>
                                <option>Mercado Pago</option>
                                <option>Transferencia</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Estatus</label>
                            <select name="status" class="form-select input-soft">
                                <option value="scheduled">Agendada</option>
                                <option value="confirmed">Confirmada</option>
                                <option value="in_progress">En curso</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-bold">Notas</label>
                        <textarea name="notes" class="form-control input-soft" rows="3" placeholder="Acuerdos, objetivo de la cita o recordatorios">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 mt-3"><i class="bi bi-calendar-plus me-1"></i> Agendar cita</button>
                </form>

                <div class="appointment-day-panel mt-3" data-day-panel>
                    <div class="appointment-day-head">
                        <div>
                            <div class="fw-bold" data-day-title>Agenda del dia</div>
                            <div class="admin-mini" data-day-subtitle>Selecciona una fecha para revisar disponibilidad.</div>
                        </div>
                        <span class="admin-tag" data-day-status>Disponible</span>
                    </div>
                    <div class="appointment-day-list" data-day-list></div>
                </div>

                <div class="fw-bold mt-4 mb-2">Horarios sugeridos</div>
                <div class="record-slot-list">
                    @foreach ($suggestedSlots as $slot)
                        <button type="button" class="record-slot {{ $slot['available'] ? '' : 'blocked' }}" data-slot-date="{{ $slot['date'] }}" data-slot-time="{{ $slot['time'] }}" @disabled(! $slot['available'])>
                            <span>
                                <strong>{{ $slot['display_date'] }} · {{ $slot['display_time'] }}</strong>
                                <small>{{ $slot['available'] ? 'Disponible para seguimiento' : 'No disponible' }}</small>
                            </span>
                            <em class="{{ $slot['available'] ? '' : 'red' }}">{{ $slot['status'] }}</em>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Citas del cliente</h2>
                <div class="admin-mini">Proximas citas y seguimiento reciente.</div>
            </div>
            <div class="admin-form-card-body">
                @if ($upcomingAppointments->isEmpty())
                    <div class="admin-helper-note">
                        <div class="fw-bold mb-1">Sin citas proximas</div>
                        <div class="admin-mini">Agenda una cita para que aparezca en el expediente y en la agenda general.</div>
                    </div>
                @else
                    <div class="record-slot-list">
                        @foreach ($upcomingAppointments as $appointment)
                            <div class="record-slot">
                                <span>
                                    <strong>{{ $appointment->starts_at->format('d/m/Y · h:i A') }}</strong>
                                    <small>{{ $appointment->appointment_type }} · {{ $appointment->modality }}</small>
                                </span>
                                <div class="d-flex flex-column align-items-end gap-2">
                                    <em class="{{ $appointment->statusClass() }}">{{ $appointment->statusLabel() }}</em>
                                    <button type="button" class="admin-btn-soft py-2 px-3" data-bs-toggle="modal" data-bs-target="#rescheduleAppointment{{ $appointment->id }}">
                                        Reagendar
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @foreach ($upcomingAppointments as $appointment)
                        <div class="modal fade modal-fitapp" id="rescheduleAppointment{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form method="POST" action="{{ route('fitapp.admin.citas.update', $appointment) }}" class="modal-content">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Reagendar cita</h5>
                                            <div class="small text-muted">{{ $appointment->starts_at->format('d/m/Y h:i A') }}</div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tipo</label>
                                            <select name="appointment_type" class="form-select input-soft">
                                                @foreach(['Seguimiento mensual', 'Valoracion inicial', 'Renovacion de plan', 'Revision tecnica'] as $type)
                                                    <option @selected($appointment->appointment_type === $type)>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-7">
                                                <label class="form-label fw-bold">Fecha</label>
                                                <input type="date" name="appointment_date" class="form-control input-soft" value="{{ $appointment->starts_at->toDateString() }}" required>
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label fw-bold">Hora</label>
                                                <input type="time" name="appointment_time" class="form-control input-soft" value="{{ $appointment->starts_at->format('H:i') }}" required>
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-0">
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Duracion</label>
                                                <select name="duration_minutes" class="form-select input-soft">
                                                    @foreach([30, 45, 60, 90] as $minutes)
                                                        <option value="{{ $minutes }}" @selected((int) $appointment->duration_minutes === $minutes)>{{ $minutes }} min</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Modalidad</label>
                                                <select name="modality" class="form-select input-soft">
                                                    <option @selected($appointment->modality === 'Presencial')>Presencial</option>
                                                    <option @selected($appointment->modality === 'Online')>Online</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-0">
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Pago</label>
                                                <select name="payment_method" class="form-select input-soft">
                                                    <option value="">Pendiente</option>
                                                    @foreach(['Efectivo', 'Mercado Pago', 'Transferencia'] as $payment)
                                                        <option @selected($appointment->payment_method === $payment)>{{ $payment }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-bold">Estatus</label>
                                                <select name="status" class="form-select input-soft">
                                                    <option value="scheduled" @selected($appointment->status === 'scheduled')>Agendada</option>
                                                    <option value="confirmed" @selected($appointment->status === 'confirmed')>Confirmada</option>
                                                    <option value="in_progress" @selected($appointment->status === 'in_progress')>En curso</option>
                                                    <option value="completed" @selected($appointment->status === 'completed')>Completada</option>
                                                    <option value="cancelled" @selected($appointment->status === 'cancelled')>Cancelada</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label fw-bold">Notas</label>
                                            <textarea name="notes" class="form-control input-soft" rows="3">{{ $appointment->notes }}</textarea>
                                        </div>
                                        <button class="btn btn-primary-custom w-100 mt-4">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        <section class="admin-form-card d-none">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Fotos de progreso</h2>
                        <div class="admin-mini">Evidencia visual enviada antes de la cita.</div>
                    </div>
                    <span class="admin-tag blue">{{ $user->progressPhotos->count() }} fotos</span>
                </div>
            </div>
            <div class="admin-form-card-body">
                @if($user->progressPhotos->isEmpty())
                    <div class="admin-helper-note">
                        <div class="fw-bold mb-1">Sin fotos enviadas</div>
                        <div class="admin-mini">Cuando el cliente suba fotos, apareceran aqui optimizadas.</div>
                    </div>
                @else
                    <div class="admin-progress-photo-grid">
                        @foreach($user->progressPhotos as $photo)
                            <a href="{{ $photo->imageUrl() }}" target="_blank" class="admin-progress-photo-card">
                                <img src="{{ $photo->imageUrl() }}" alt="Foto de progreso">
                                <span>
                                    <strong>{{ $photo->created_at->format('d/m/Y') }}</strong>
                                    <small>{{ $photo->appointment?->starts_at?->format('d/m/Y') ? 'Cita '.$photo->appointment->starts_at->format('d/m/Y') : 'Sin cita vinculada' }} · {{ $photo->savedPercent() }}% menos peso</small>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Notas de consulta</h2>
                <div class="admin-mini">Borrador visual para capturar acuerdos.</div>
            </div>
            <div class="admin-form-card-body">
                <textarea class="form-control input-soft record-note-area" rows="6">Cliente reporta adherencia, descanso y sensaciones del plan. Aqui despues podemos guardar notas reales por cita.</textarea>
                <div class="admin-card-actions">
                    <button class="admin-btn-soft" type="button"><i class="bi bi-save"></i> Guardar nota</button>
                    <button class="admin-btn-soft" type="button"><i class="bi bi-send"></i> Enviar resumen</button>
                </div>
            </div>
        </section>
    </aside>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const appointmentDateEvents = @json($appointmentDateEvents);
        const blockedDates = new Set(@json($blockedDates));
        const dateInput = document.querySelector('[data-appointment-date]');
        const submitButton = document.querySelector('.record-appointment-form button[type="submit"]');
        const dayTitle = document.querySelector('[data-day-title]');
        const daySubtitle = document.querySelector('[data-day-subtitle]');
        const dayStatus = document.querySelector('[data-day-status]');
        const dayList = document.querySelector('[data-day-list]');

        document.querySelectorAll('[data-record-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.recordTab;

                document.querySelectorAll('[data-record-tab]').forEach((button) => button.classList.toggle('active', button === tab));
                document.querySelectorAll('[data-record-panel]').forEach((panel) => panel.classList.toggle('active', panel.dataset.recordPanel === target));
            });
        });

        document.querySelectorAll('[data-measurement-toggle]').forEach((toggle) => {
            toggle.addEventListener('click', () => {
                const item = toggle.closest('.measurement-accordion-item');
                item?.classList.toggle('is-open');
            });
        });

        document.querySelectorAll('[data-album-toggle]').forEach((album) => {
            album.addEventListener('click', () => {
                const panel = document.querySelector(`[data-album-panel="${album.dataset.albumToggle}"]`);

                album.classList.toggle('is-open');
                panel?.classList.toggle('is-open');
            });
        });

        const comparePanel = document.querySelector('[data-photo-compare-panel]');
        const compareInputs = Array.from(document.querySelectorAll('[data-compare-album]'));
        const compareColumns = Array.from(document.querySelectorAll('[data-compare-column]'));
        const renderPhotoCompare = () => {
            if (!comparePanel || compareColumns.length < 2) {
                return;
            }

            const selected = compareInputs.filter((input) => input.checked).slice(0, 2);
            comparePanel.classList.toggle('d-none', selected.length < 2);

            compareColumns.forEach((column, index) => {
                const input = selected[index];

                if (!input) {
                    column.innerHTML = '';
                    return;
                }

                const albumButton = document.querySelector(`[data-album-toggle="${input.value}"]`);
                const albumPanel = document.querySelector(`[data-album-panel="${input.value}"]`);
                const photos = albumPanel?.querySelector('.admin-progress-photo-grid')?.innerHTML || '<div class="admin-helper-note">Sin fotos en este album.</div>';

                column.innerHTML = `
                    <div class="photo-compare-title">${albumButton?.dataset.albumTitle || 'Album'}</div>
                    <div class="admin-progress-photo-grid">${photos}</div>
                `;
            });
        };

        compareInputs.forEach((input) => {
            input.addEventListener('click', (event) => event.stopPropagation());
            input.addEventListener('change', () => {
                const selected = compareInputs.filter((candidate) => candidate.checked);

                if (selected.length > 2) {
                    selected.find((candidate) => candidate !== input).checked = false;
                }

                renderPhotoCompare();
            });
        });

        document.querySelector('[data-clear-photo-compare]')?.addEventListener('click', () => {
            compareInputs.forEach((input) => {
                input.checked = false;
            });
            renderPhotoCompare();
        });

        const renderDayAgenda = () => {
            if (!dateInput || !dayList || !dayTitle || !daySubtitle || !dayStatus) {
                return;
            }

            const selectedDate = dateInput.value;
            const events = appointmentDateEvents[selectedDate] || [];
            const isBlocked = blockedDates.has(selectedDate);

            dayTitle.textContent = selectedDate ? `Agenda del ${selectedDate}` : 'Agenda del dia';
            daySubtitle.textContent = isBlocked
                ? 'Este dia tiene bloqueo completo y no se puede seleccionar.'
                : (events.length ? `${events.length} registro(s) en este dia.` : 'No hay citas ni bloqueos para esta fecha.');
            dayStatus.textContent = isBlocked ? 'Bloqueado' : (events.length ? 'Con agenda' : 'Libre');
            dayStatus.classList.toggle('red', isBlocked);
            dayStatus.classList.toggle('blue', !isBlocked && events.length > 0);
            submitButton?.toggleAttribute('disabled', isBlocked);

            if (!events.length) {
                dayList.innerHTML = '<div class="admin-helper-note mt-2"><div class="admin-mini">Dia libre para agendar.</div></div>';
                return;
            }

            dayList.innerHTML = events.map((event) => `
                <div class="appointment-day-item ${event.kind === 'block' ? 'is-block' : ''}">
                    <span>
                        <strong>${event.time}</strong>
                        <small>${event.title} · ${event.detail}</small>
                    </span>
                    <em>${event.status}</em>
                </div>
            `).join('');
        };

        document.querySelectorAll('[data-slot-date][data-slot-time]').forEach((slot) => {
            slot.addEventListener('click', () => {
                document.querySelector('[data-appointment-date]').value = slot.dataset.slotDate;
                document.querySelector('[data-appointment-time]').value = slot.datasetSlotTime || slot.dataset.slotTime;
                renderDayAgenda();
            });
        });

        dateInput?.addEventListener('change', renderDayAgenda);
        renderDayAgenda();
    });
</script>
@endpush
