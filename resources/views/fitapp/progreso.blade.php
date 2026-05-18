@extends('layouts.fitapp')

@section('title', 'Progreso | FitApp')

@section('content')
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
                <div class="metric-value">72.4</div>
                <small class="text-muted">kg</small>
            </div>
        </div>
        <div class="col-6">
            <div class="metric-card">
                <div class="metric-label">Cumplimiento</div>
                <div class="metric-value">85%</div>
                <small class="text-muted">este mes</small>
            </div>
        </div>
    </div>

    <div class="hero-card hero-dark mb-4">
        <div class="fw-bold mb-2">Resumen mensual</div>
        <div class="fit-subtitle text-white-50 mb-3">
            Vas bien. Tus entrenamientos y evidencias muestran buena constancia.
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-white-50">Rutinas completadas</span>
            <span class="fw-bold">12 / 16</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-white-50">Fotos de comida enviadas</span>
            <span class="fw-bold">18</span>
        </div>

        <div class="d-flex justify-content-between">
            <span class="text-white-50">Evaluaciones del coach</span>
            <span class="fw-bold">6</span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Metas del mes</div>

        <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
                <span>Entrenar 4 veces por semana</span>
                <span class="status-pill status-ok">80%</span>
            </div>
            <div class="progress-slim">
                <div class="bar" style="width:80%;"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between mb-2">
                <span>Subir evidencias</span>
                <span class="status-pill status-warn">65%</span>
            </div>
            <div class="progress-slim">
                <div class="bar" style="width:65%;"></div>
            </div>
        </div>

        <div>
            <div class="d-flex justify-content-between mb-2">
                <span>Cumplir plan nutricional</span>
                <span class="status-pill status-ok">85%</span>
            </div>
            <div class="progress-slim">
                <div class="bar" style="width:85%;"></div>
            </div>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
            <div>
                <div class="fw-bold">Mediciones corporales</div>
                <div class="fit-subtitle">Ultima valoracion: 15 de Abril 2026</div>
            </div>
            <span class="status-pill status-ok">Registrada</span>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">14.73%</div>
                    <div class="label">Grasa corporal</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">65.3 kg</div>
                    <div class="label">Peso corporal</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">55.68 kg</div>
                    <div class="label">Masa magra</div>
                </div>
            </div>
            <div class="col-6">
                <div class="profile-stat">
                    <div class="value">81.2 cm</div>
                    <div class="label">Cintura</div>
                </div>
            </div>
        </div>

        <div class="soft-divider"></div>

        <a href="{{ route('fitapp.progreso') }}" class="btn btn-primary-custom w-100 mb-3">
            Ver reporte visual de resultados
        </a>

        <div class="fw-bold mb-3">Historial</div>
        <div class="d-grid gap-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="fw-bold">15 Abr 2026</div>
                    <div class="fit-subtitle">Seguimiento con medicion completa</div>
                </div>
                <span class="status-pill status-ok">Actual</span>
            </div>
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="fw-bold">15 Mar 2026</div>
                    <div class="fit-subtitle">Valoracion anterior para comparativo</div>
                </div>
                <span class="status-pill status-warn">Anterior</span>
            </div>
        </div>
    </div>

    <div class="surface-card p-4">
        <div class="fw-bold mb-3">Notas del coach</div>
        <div class="fit-subtitle">
            Buena adherencia general. En la próxima semana se puede subir un poco la intensidad en espalda y mejorar la distribución de proteína por la noche.
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
