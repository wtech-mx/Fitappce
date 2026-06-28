@extends('layouts.fitapp')

@section('title', 'Inicio | FitApp')

@section('content')
@php
    $firstName = str($user->name)->before(' ')->toString();
    $days = $workout?->days ?? collect();
    $mealCount = $nutritionMealCount ?? ($nutrition?->meals->filter(fn ($meal) => $meal->items->isNotEmpty())->count() ?? 0);
    $todayEvidenceCount = $todayWorkoutDay?->exercises->where('requires_evidence', true)->count() ?? 0;
    $serviceLabel = $workout && $nutrition ? 'Entrenamiento + nutricion' : ($workout ? 'Entrenamiento' : ($nutrition ? 'Nutricion' : 'Sin plan activo'));
    $focus = $workout?->goal ?: ($nutrition?->goal ?: ($user->goal ?: 'Tu progreso personal'));
@endphp

<div class="section-pad dashboard-mobile">
    <div class="app-bar pt-1">
        <div class="min-w-0">
            <div class="page-kicker mb-1"><i class="bi bi-sunrise"></i> Hoy</div>
            <h1 class="fit-title">Hola, {{ $firstName }}</h1>
            <p class="fit-subtitle mb-0">Tu enfoque actual: {{ $focus }}</p>
        </div>
        <a href="{{ route('fitapp.perfil') }}" class="avatar-xl text-decoration-none flex-shrink-0">{{ $user->initials() }}</a>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="page-kicker text-white mb-1"><i class="bi bi-stars"></i> Plan activo</div>
                <h2 class="h5 fw-bold mb-1">{{ $workout?->name ?: ($nutrition?->name ?: 'Plan pendiente') }}</h2>
                <div class="text-white-50 small">{{ $workout ? 'Semana '.$currentWeek.' de '.$weekTotal.' - ' : '' }}{{ $serviceLabel }}</div>
            </div>
            <span class="status-pill" style="background:rgba(245,247,73,.18); color:#F5F749;">{{ $workout || $nutrition ? 'Activo' : 'Pendiente' }}</span>
        </div>
        <p class="text-white-50 small mb-0">
            @if($todayWorkoutDay)
                {{ $todayWorkoutDay->day_name }}: {{ $todayWorkoutDay->focus ?: 'entrenamiento asignado' }}. Tienes {{ $todayWorkoutDay->exercises->count() }} ejercicios{{ $todayEvidenceCount ? ' y '.$todayEvidenceCount.' '.($todayEvidenceCount === 1 ? 'evidencia requerida' : 'evidencias requeridas') : '' }}.
            @elseif($nutrition)
                Tu plan alimentario tiene {{ $mealCount }} comidas y {{ number_format($nutritionCalories, 0) }} kcal asignadas.
            @else
                Tu coach aun no ha asignado un plan activo.
            @endif
        </p>
    </div>

    <div class="quick-link-card mb-3">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker mb-1"><i class="bi bi-calendar2-check"></i> Proxima cita</div>
                @if($nextAppointment)
                    <div class="fw-bold mb-1">{{ $nextAppointment->starts_at->format('d/m/Y · h:i A') }}</div>
                    <div class="fit-subtitle">{{ $nextAppointment->appointment_type ?: 'Seguimiento' }} · {{ $nextAppointment->modality }}</div>
                @else
                    <div class="fw-bold mb-1">Sin cita programada</div>
                    <div class="fit-subtitle">Tu coach te avisara cuando quede agendada.</div>
                @endif
            </div>
            <span class="status-pill {{ $nextAppointment ? '' : 'status-warn' }}" @if($nextAppointment) style="background:#dff1f8;color:#2E86AB;" @endif>
                {{ $nextAppointment ? 'Agendada' : 'Pendiente' }}
            </span>
        </div>
    </div>

    <a href="{{ route('fitapp.fotos-progreso') }}" class="quick-link-card mb-4 text-decoration-none text-dark">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker mb-1"><i class="bi bi-camera"></i> Fotos de avance</div>
                <div class="fw-bold mb-1">{{ $photoUploadWindow['is_open'] ? 'Ya puedes subir tus fotos' : 'Preparalas para tu cita' }}</div>
                <div class="fit-subtitle">
                    {{ $nextAppointment ? 'Ventana: 7 dias antes de tu cita.' : 'Aparecera cuando tengas cita programada.' }}
                </div>
            </div>
            <span class="status-pill {{ $photoUploadWindow['is_open'] ? 'status-ok' : 'status-warn' }}">{{ $photoUploadWindow['label'] }}</span>
        </div>
    </a>

    <div class="row g-3 mb-4">
        <div class="col-6"><a href="{{ route('fitapp.rutina') }}" class="card-link-clean"><div class="metric-card is-clickable"><div class="metric-label">Rutina</div><div class="metric-value">{{ $days->count() }}</div><small class="text-muted">dias asignados</small></div></a></div>
        <div class="col-6"><a href="{{ route('fitapp.progreso-corporal') }}" class="card-link-clean"><div class="metric-card is-clickable"><div class="metric-label">Progreso</div><div class="metric-value">{{ $measurementCount }}</div><small class="text-muted">mediciones</small></div></a></div>
        <div class="col-6"><a href="{{ route('fitapp.plan') }}" class="card-link-clean"><div class="metric-card is-clickable"><div class="metric-label">Nutricion</div><div class="metric-value">{{ $mealCount }}</div><small class="text-muted">comidas del plan</small></div></a></div>
        <div class="col-6"><a href="{{ route('fitapp.plan') }}" class="card-link-clean"><div class="metric-card is-clickable"><div class="metric-label">Plan</div><div class="metric-value">{{ number_format($nutritionCalories, 0) }}</div><small class="text-muted">kcal del dia</small></div></a></div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Tu rutina activa</h2>
        <a href="{{ route('fitapp.rutina') }}" class="small text-decoration-none text-primary-custom">Abrir rutina</a>
    </div>

    @if($workout)
        <div class="week-scroller mb-4">
            @for($week = 1; $week <= $weekTotal; $week++)
                <span class="chip {{ $week === $currentWeek ? 'active' : '' }}">Semana {{ $week }}</span>
            @endfor
        </div>
        <div class="d-grid gap-3 mb-4">
            @forelse($days as $day)
                @php
                    $isToday = str($day->day_name)->ascii()->lower()->toString() === str($todayName)->ascii()->lower()->toString();
                    $evidenceCount = $day->exercises->where('requires_evidence', true)->count();
                @endphp
                <a href="{{ route('fitapp.rutina-dia', $day) }}" class="day-card-link">
                    <div class="day-card p-3 is-clickable {{ $isToday ? 'is-today' : '' }}">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-bold">{{ $day->day_name }}</div>
                                <div class="mini-note">{{ $day->focus ?: 'Entrenamiento asignado' }} - {{ $day->exercises->count() }} ejercicios{{ $evidenceCount ? ' - '.$evidenceCount.' '.($evidenceCount === 1 ? 'evidencia' : 'evidencias') : '' }}</div>
                            </div>
                            <span class="status-pill {{ $isToday ? '' : 'status-warn' }}" @if($isToday) style="background:#dff1f8;color:#2E86AB;" @endif>{{ $isToday ? 'Hoy' : 'Asignado' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="coach-note-box">Tu rutina activa aun no tiene dias capturados.</div>
            @endforelse
        </div>
    @else
        <div class="coach-note-box mb-4"><div class="fw-bold mb-1">Rutina pendiente</div><div class="fit-subtitle">Tu coach aun no ha asignado una rutina activa.</div></div>
    @endif

    @if($todayWorkoutDay)
        <a href="{{ route('fitapp.rutina-dia', $todayWorkoutDay) }}" class="quick-link-card mb-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div><div class="page-kicker mb-1"><i class="bi bi-play-circle"></i> Entrenamiento</div><div class="fw-bold mb-1">{{ $todayWorkoutDay->focus ?: $todayWorkoutDay->day_name }}</div><div class="fit-subtitle">{{ $todayWorkoutDay->exercises->count() }} ejercicios{{ $todayWorkoutDay->estimated_time ? ' - '.$todayWorkoutDay->estimated_time : '' }}{{ $todayEvidenceCount ? ' - '.$todayEvidenceCount.' '.($todayEvidenceCount === 1 ? 'evidencia' : 'evidencias') : '' }}</div></div>
                <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
            </div>
        </a>
    @endif

    <a href="{{ route('fitapp.plan') }}" class="quick-link-card mb-3">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div><div class="page-kicker mb-1"><i class="bi bi-cup-hot"></i> Nutricion</div><div class="fw-bold mb-1">{{ $nutrition?->name ?: 'Plan pendiente' }}</div><div class="fit-subtitle">{{ $nutrition ? $mealCount.' comidas - '.number_format($nutritionCalories, 0).' kcal'.($nutrition->daily_water ? ' - Agua: '.$nutrition->daily_water : '') : 'Tu coach aun no ha asignado un plan alimentario.' }}</div></div>
            <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
        </div>
    </a>

    <a href="{{ route('fitapp.progreso-corporal') }}" class="quick-link-card">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div><div class="page-kicker mb-1"><i class="bi bi-graph-up-arrow"></i> Seguimiento</div><div class="fw-bold mb-1">{{ $latestMeasurement ? 'Ultima valoracion '.$latestMeasurement->measured_at->format('d/m/Y') : 'Primera valoracion pendiente' }}</div><div class="fit-subtitle">{{ $latestMeasurement?->notes ?: 'Aqui veras las observaciones reales que deje tu coach.' }}</div></div>
            <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
        </div>
    </a>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
