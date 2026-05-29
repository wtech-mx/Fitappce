@extends('layouts.fitapp')

@section('title', 'Rutina semanal | FitApp')

@section('content')
@php
    $days = $activePlan?->days ?? collect();
    $exerciseCount = $activePlan?->exerciseCount() ?? 0;
    $evidenceCount = $activePlan?->evidenceCount() ?? 0;
@endphp

<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.dashboard') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Rutina</span>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-calendar-week"></i> Plan activo
        </div>
        <h1 class="fit-title mb-2">Tu semana de entrenamiento</h1>
        <p class="fit-subtitle mb-0">
            Aqui ves los dias que te asigno tu coach. Toca uno para entrar al detalle y revisar los ejercicios.
        </p>
    </div>

    @if($activePlan)
        <div class="hero-card hero-dark mb-4">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <div>
                    <div class="page-kicker text-white mb-1">
                        <i class="bi bi-stars"></i> {{ $activePlan->level ?: 'Rutina personalizada' }}
                    </div>
                    <h2 class="h5 fw-bold mb-1">{{ $activePlan->name }}</h2>
                    <div class="small text-white-50">
                        {{ $activePlan->goal ?: 'Objetivo definido por tu coach' }}
                    </div>
                </div>
                <span class="status-pill" style="background:rgba(245,247,73,.18); color:#F5F749;">
                    Activo
                </span>
            </div>

            <div class="routine-day-meta">
                <span class="routine-meta-pill">
                    <i class="bi bi-calendar-check"></i> {{ $activePlan->days_per_week ?: $days->count() }} dias
                </span>
                <span class="routine-meta-pill">
                    <i class="bi bi-list-check"></i> {{ $exerciseCount }} ejercicios
                </span>
                <span class="routine-meta-pill is-required">
                    <i class="bi bi-camera-video"></i> {{ $evidenceCount }} evidencias
                </span>
            </div>

            @if($activePlan->notes)
                <div class="small text-white-50 mt-3">{{ $activePlan->notes }}</div>
            @endif
        </div>

        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Dias de la semana</h2>
            <span class="mini-note">Selecciona un dia</span>
        </div>

        <div class="d-grid gap-3">
            @forelse($days as $day)
                @php
                    $dayEvidenceCount = $day->exercises->where('requires_evidence', true)->count();
                @endphp

                <a href="{{ route('fitapp.rutina-dia', $day) }}" class="routine-day-link">
                    <div class="routine-day-item {{ $loop->first ? 'is-active' : '' }}">
                        <div class="d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div class="fw-bold">{{ $day->day_name }}</div>
                                <div class="mini-note">{{ $day->focus ?: 'Entrenamiento asignado' }}</div>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </div>

                        <div class="routine-day-meta">
                            <span class="routine-meta-pill">
                                <i class="bi bi-list-check"></i> {{ $day->exercises->count() }} ejercicios
                            </span>
                            @if($dayEvidenceCount)
                                <span class="routine-meta-pill is-required">
                                    <i class="bi bi-camera-video"></i> {{ $dayEvidenceCount }} evidencias
                                </span>
                            @endif
                            @if($day->estimated_time)
                                <span class="routine-meta-pill">
                                    <i class="bi bi-clock"></i> {{ $day->estimated_time }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="coach-note-box">
                    <div class="fw-bold mb-2">Rutina sin dias capturados</div>
                    <div class="fit-subtitle mb-0">Tu coach ya creo la rutina, pero todavia no agrego los dias de entrenamiento.</div>
                </div>
            @endforelse
        </div>

        <div class="coach-note-box mt-4">
            <div class="fw-bold mb-2">Nota del coach</div>
            <div class="fit-subtitle mb-0">
                Los ejercicios marcados con evidencia requieren que subas un video individual para que el coach pueda revisarlo mejor.
            </div>
        </div>
    @else
        <div class="coach-note-box">
            <div class="fw-bold mb-2">Aun no tienes rutina activa</div>
            <div class="fit-subtitle mb-0">
                Cuando tu coach te asigne una rutina, aqui apareceran tus dias y ejercicios.
            </div>
        </div>
    @endif
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
