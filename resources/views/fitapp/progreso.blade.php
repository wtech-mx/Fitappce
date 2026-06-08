@extends('layouts.fitapp')

@section('title', 'Progreso | FitApp')

@section('content')
@php
    $current = $display['current'];
    $latestDate = $display['latest_date'];
    $formatNumber = fn ($value, int $decimals = 2) => filled($value) ? number_format((float) $value, $decimals) : '-';
    $unlockedAchievements = $achievements->filter(fn ($achievement) => optional($userAchievements->get($achievement->id))->unlocked_at);
    $achievementTotal = $achievements->count();
    $achievementPercent = $achievementTotal ? round(($unlockedAchievements->count() / $achievementTotal) * 100) : 0;
    $nutritionMacros = $activeNutritionPlan?->macroTotals();
    $nutritionCalories = $nutritionMacros['calories'] ?? $nutritionMacros['kcal'] ?? $activeNutritionPlan?->target_calories ?? 0;
@endphp

<div class="section-pad">
    <div class="app-bar">
        <div>
            <div class="page-kicker mb-1">
                <i class="bi bi-graph-up-arrow"></i> Seguimiento
            </div>
            <h1 class="fit-title">Tu progreso</h1>
        </div>
        <button class="app-bar-btn text-dark" type="button">
            <i class="bi bi-calendar3"></i>
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="metric-card">
                <div class="metric-label">Peso actual</div>
                <div class="metric-value">{{ $formatNumber($current['weight'], 1) }}</div>
                <small class="text-muted">kg</small>
            </div>
        </div>
        <div class="col-6">
            <div class="metric-card">
                <div class="metric-label">Trofeos</div>
                <div class="metric-value">{{ $unlockedAchievements->count() }}</div>
                <small class="text-muted">de {{ $achievementTotal }}</small>
            </div>
        </div>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="fw-bold mb-2">Resumen mensual</div>
        <div class="fit-subtitle text-white-50 mb-3">
            {{ $latestMeasurement ? 'Tu ultima medicion ya esta registrada. Revisa tus cambios y el reporte visual.' : 'Aun no tienes mediciones registradas. Tu coach capturara tu primera valoracion pronto.' }}
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-white-50">Ultima valoracion</span>
            <span class="fw-bold">{{ $latestDate ? $latestDate->format('d/m/Y') : 'Pendiente' }}</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-white-50">Grasa corporal</span>
            <span class="fw-bold">{{ $formatNumber($current['body_fat']) }}%</span>
        </div>

        <div class="d-flex justify-content-between">
            <span class="text-white-50">Cintura</span>
            <span class="fw-bold">{{ $formatNumber($current['waist']) }} cm</span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="fw-bold">Tu vitrina de trofeos</div>
                <div class="fit-subtitle">Logros desbloqueados por constancia, nutricion, rendimiento y progreso.</div>
            </div>
            <a href="{{ route('fitapp.logros') }}" class="status-pill text-decoration-none" style="background:#dff1f8;color:#2E86AB;">Ver todo</a>
        </div>

        <div class="achievement-mini-progress mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>{{ $unlockedAchievements->count() }} de {{ $achievementTotal }} ganados</span>
                <strong>{{ $achievementPercent }}%</strong>
            </div>
            <div class="progress-slim">
                <div class="bar" style="width:{{ $achievementPercent }}%;"></div>
            </div>
        </div>

        @include('fitapp.partials.achievement-shelf', [
            'achievements' => $achievements->take(6),
            'userAchievements' => $userAchievements,
            'compact' => true,
        ])
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <a href="{{ route('fitapp.rutina') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Rutina activa</div>
                    <div class="metric-value">{{ $activeWorkoutPlan?->days->count() ?: 0 }}</div>
                    <small class="text-muted">{{ $activeWorkoutPlan ? 'dias asignados' : 'pendiente' }}</small>
                </div>
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('fitapp.plan') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Plan kcal</div>
                    <div class="metric-value">{{ number_format((float) $nutritionCalories, 0) }}</div>
                    <small class="text-muted">{{ $activeNutritionPlan ? 'kcal diarias' : 'pendiente' }}</small>
                </div>
            </a>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="fw-bold">Mediciones corporales</div>
                <div class="fit-subtitle">Ultima valoracion: {{ $latestDate ? $latestDate->format('d/m/Y') : 'Pendiente' }}</div>
            </div>
            <span class="status-pill {{ $latestMeasurement ? 'status-ok' : 'status-warn' }}">{{ $latestMeasurement ? 'Registrada' : 'Pendiente' }}</span>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">{{ $formatNumber($current['body_fat']) }}%</div>
                    <div class="label">Grasa corporal</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">{{ $formatNumber($current['weight'], 1) }} kg</div>
                    <div class="label">Peso corporal</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">{{ $formatNumber($current['lean_mass']) }} kg</div>
                    <div class="label">Masa magra</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">{{ $formatNumber($current['waist'], 1) }} cm</div>
                    <div class="label">Cintura</div>
                </div>
            </div>
        </div>

        <div class="soft-divider"></div>

        <a href="{{ route('fitapp.progreso-corporal') }}" class="btn btn-primary-custom w-100 mb-3">
            Ver reporte visual de resultados
        </a>

        <div class="fw-bold mb-3">Historial</div>
        <div class="d-grid gap-3">
            @forelse($measurements->take(4) as $measurement)
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="fw-bold">{{ $measurement->measured_at->format('d/m/Y') }}</div>
                        <div class="fit-subtitle">{{ $measurement->appointment_type }} - {{ $measurement->weight ? $measurement->weight.' kg' : 'peso pendiente' }}</div>
                    </div>
                    <span class="status-pill {{ $loop->first ? 'status-ok' : 'status-warn' }}">{{ $loop->first ? 'Actual' : 'Anterior' }}</span>
                </div>
            @empty
                <div class="fit-subtitle">Aun no hay historial de mediciones.</div>
            @endforelse
        </div>
    </div>

    <div class="surface-card p-4">
        <div class="fw-bold mb-3">Notas del coach</div>
        <div class="fit-subtitle">
            {{ $latestMeasurement?->notes ?: 'Tu coach aun no ha dejado notas sobre la ultima medicion.' }}
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
