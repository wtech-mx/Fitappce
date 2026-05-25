@extends('layouts.fitapp')

@section('title', 'Dashboard | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar pt-1">
        <div>
            <div class="page-kicker mb-1">
                <i class="bi bi-sunrise"></i> Hoy
            </div>
            <h1 class="fit-title">Hola, Carlos 👋</h1>
            <p class="fit-subtitle mb-0">Tu enfoque actual: masa muscular + nutrición</p>
        </div>

        <a href="{{ route('fitapp.perfil') }}" class="avatar-xl text-decoration-none">
            C
        </a>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <div class="page-kicker text-white mb-1">
                    <i class="bi bi-stars"></i> Plan activo
                </div>
                <h2 class="h5 fw-bold mb-1">Plan personalizado</h2>
                <div class="text-white-50 small">Semana 2 de 4 · Entrenamiento + nutrición</div>
            </div>
            <span class="status-pill" style="background:rgba(245,247,73,.18); color:#F5F749;">
                Activo
            </span>
        </div>

        <p class="text-white-50 small mb-0">
            Hoy toca espalda y bíceps. Tienes 2 ejercicios con evidencia obligatoria y 3 comidas por registrar.
        </p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <a href="{{ route('fitapp.rutina') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Rutinas</div>
                    <div class="metric-value">12</div>
                    <small class="text-muted">completadas</small>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="{{ route('fitapp.progreso') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Progreso</div>
                    <div class="metric-value">85%</div>
                    <small class="text-muted">cumplimiento</small>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="{{ route('fitapp.nutricion') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Nutrición</div>
                    <div class="metric-value">3</div>
                    <small class="text-muted">comidas pendientes</small>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="{{ route('fitapp.plan') }}" class="card-link-clean">
                <div class="metric-card is-clickable">
                    <div class="metric-label">Plan</div>
                    <div class="metric-value">2100</div>
                    <small class="text-muted">kcal del día</small>
                </div>
            </a>
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Tu rutina del mes</h2>
        <a href="{{ route('fitapp.rutina') }}" class="small text-decoration-none text-primary-custom">Abrir rutina</a>
    </div>

    <div class="week-scroller mb-4">
        <span class="chip">Semana 1</span>
        <span class="chip active">Semana 2</span>
        <span class="chip">Semana 3</span>
        <span class="chip">Semana 4</span>
    </div>

    <div class="d-grid gap-3 mb-4">
        <a href="{{ route('fitapp.rutina-dia') }}" class="day-card-link">
            <div class="day-card p-3 is-clickable">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Lunes</div>
                        <div class="mini-note">Pierna y glúteo</div>
                    </div>
                    <span class="status-pill status-ok">Completado</span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="day-card-link">
            <div class="day-card p-3 is-clickable is-today">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Martes</div>
                        <div class="mini-note">Espalda y bíceps · 2 evidencias requeridas</div>
                    </div>
                    <span class="status-pill" style="background:#dff1f8;color:#2E86AB;">Hoy</span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="day-card-link">
            <div class="day-card p-3 is-clickable">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Miércoles</div>
                        <div class="mini-note">Cardio + core</div>
                    </div>
                    <span class="status-pill status-warn">Pendiente</span>
                </div>
            </div>
        </a>

        <a href="{{ route('fitapp.rutina-dia') }}" class="day-card-link">
            <div class="day-card p-3 is-clickable">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold">Jueves</div>
                        <div class="mini-note">Pecho y tríceps</div>
                    </div>
                    <span class="status-pill status-warn">Pendiente</span>
                </div>
            </div>
        </a>
    </div>


    <a href="{{ route('fitapp.rutina-dia') }}" class="quick-link-card mb-3">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker mb-1">
                    <i class="bi bi-play-circle"></i> Rutina de hoy
                </div>
                <div class="fw-bold mb-1">Espalda y bíceps</div>
                <div class="fit-subtitle">6 ejercicios · 55 min · videos del coach disponibles</div>
            </div>
            <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
        </div>
    </a>

    <a href="{{ route('fitapp.nutricion') }}" class="quick-link-card mb-3">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker mb-1">
                    <i class="bi bi-cup-hot"></i> Nutrición de hoy
                </div>
                <div class="fw-bold mb-1">Tienes 3 comidas por registrar</div>
                <div class="fit-subtitle">Sube foto de comida, colación y cena para revisión.</div>
            </div>
            <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
        </div>
    </a>

    <a href="{{ route('fitapp.progreso') }}" class="quick-link-card">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker mb-1">
                    <i class="bi bi-graph-up-arrow"></i> Seguimiento
                </div>
                <div class="fw-bold mb-1">Tu coach dejó una observación</div>
                <div class="fit-subtitle">Buen avance, pero hay que mejorar la técnica en remo sentado.</div>
            </div>
            <i class="bi bi-chevron-right fs-5 text-primary-custom"></i>
        </div>
    </a>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
