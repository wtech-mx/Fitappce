@extends('layouts.fitapp')

@section('title', 'Rutina semanal | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.dashboard') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Rutina</span>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-calendar-week"></i> Semana 2 de 4
        </div>
        <h1 class="fit-title mb-2">Tu semana de entrenamiento</h1>
        <p class="fit-subtitle mb-0">
            Aquí ves tus días asignados. Toca uno para entrar al detalle, revisar ejercicios y ver los videos del coach.
        </p>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="page-kicker text-white mb-1">
                    <i class="bi bi-stars"></i> Plan activo
                </div>
                <h2 class="h5 fw-bold mb-1">Masa muscular · Rutina + nutrición</h2>
                <div class="small text-white-50">Organizado por días, con seguimiento por ejercicio.</div>
            </div>
            <span class="status-pill" style="background:rgba(245,247,73,.18); color:#F5F749;">
                Activo
            </span>
        </div>

        <div class="small text-white-50 mb-0">
            Esta semana tienes 4 días de entrenamiento. El coach marcó ejercicios específicos donde debes subir evidencia en video.
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Días de la semana</h2>
        <span class="mini-note">Selecciona un día</span>
    </div>

    <div class="d-grid gap-3">
        <a href="{{ route('fitapp.rutina-dia') }}" class="routine-day-link">
            <div class="routine-day-item is-active">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="fw-bold">Lunes</div>
                        <div class="mini-note">Pierna y glúteo</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="routine-day-meta">
                    <span class="routine-meta-pill">
                        <i class="bi bi-list-check"></i> 5 ejercicios
                    </span>
                    <span class="routine-meta-pill is-required">
                        <i class="bi bi-camera-video"></i> 2 evidencias
                    </span>
                    <span class="routine-meta-pill">
                        <i class="bi bi-clock"></i> 60 min
                    </span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="routine-day-link">
            <div class="routine-day-item">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="fw-bold">Martes</div>
                        <div class="mini-note">Espalda y bíceps</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="routine-day-meta">
                    <span class="routine-meta-pill">
                        <i class="bi bi-list-check"></i> 6 ejercicios
                    </span>
                    <span class="routine-meta-pill is-required">
                        <i class="bi bi-camera-video"></i> 2 evidencias
                    </span>
                    <span class="routine-meta-pill">
                        <i class="bi bi-clock"></i> 55 min
                    </span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="routine-day-link">
            <div class="routine-day-item">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="fw-bold">Miércoles</div>
                        <div class="mini-note">Cardio + core</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="routine-day-meta">
                    <span class="routine-meta-pill">
                        <i class="bi bi-list-check"></i> 4 ejercicios
                    </span>
                    <span class="routine-meta-pill">
                        <i class="bi bi-clock"></i> 40 min
                    </span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="routine-day-link">
            <div class="routine-day-item">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <div class="fw-bold">Jueves</div>
                        <div class="mini-note">Pecho y tríceps</div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="routine-day-meta">
                    <span class="routine-meta-pill">
                        <i class="bi bi-list-check"></i> 5 ejercicios
                    </span>
                    <span class="routine-meta-pill is-required">
                        <i class="bi bi-camera-video"></i> 1 evidencia
                    </span>
                    <span class="routine-meta-pill">
                        <i class="bi bi-clock"></i> 50 min
                    </span>
                </div>
            </div>
        </a>
    </div>

    <div class="coach-note-box mt-4">
        <div class="fw-bold mb-2">Nota del coach</div>
        <div class="fit-subtitle mb-0">
            En los ejercicios con evidencia obligatoria, el usuario debe subir video individual. Así la evaluación es más precisa y no se vuelve un megavideo eterno de media hora.
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
