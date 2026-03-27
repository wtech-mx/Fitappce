@extends('layouts.fitapp')

@section('title', 'Detalle de rutina | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.rutina') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Detalle del día</span>
    </div>

    <div class="day-focus-card mb-4">
        <div class="page-kicker text-white mb-1">
            <i class="bi bi-calendar-day"></i> Lunes
        </div>
        <h1 class="fit-title text-white mb-2">Pierna y glúteo</h1>
        <p class="text-white-50 mb-0">
            Rutina enfocada en fuerza base, activación de glúteo y estabilidad de piernas.
        </p>

        <div class="day-focus-grid">
            <div class="day-focus-stat">
                <div class="value">5</div>
                <div class="label">Ejercicios</div>
            </div>
            <div class="day-focus-stat">
                <div class="value">2</div>
                <div class="label">Evidencias</div>
            </div>
            <div class="day-focus-stat">
                <div class="value">60m</div>
                <div class="label">Duración</div>
            </div>
        </div>
    </div>

    <div class="coach-note-box mb-4">
        <div class="fw-bold mb-2">Indicaciones generales del coach</div>
        <ul class="exercise-info-list mb-0">
            <li>Calienta 5 a 8 minutos antes de empezar</li>
            <li>Haz pausa corta entre series y prioriza técnica</li>
            <li>En los ejercicios marcados, sube video individual para revisión</li>
        </ul>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Ejercicios del día</h2>
        <span class="mini-note">Toca para abrir demo</span>
    </div>

    <div class="d-grid gap-3">
        {{-- 1 --}}
        <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#modalSentadillaGoblet">
            <div class="exercise-card">
                <div class="exercise-card-head">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="exercise-thumb">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Sentadilla Goblet</div>
                            <div class="exercise-sub">4 series x 12 repeticiones · descanso 45s</div>

                            <div class="exercise-tags">
                                <span class="exercise-tag is-coach">
                                    <i class="bi bi-camera-video"></i> Video del coach
                                </span>
                                <span class="exercise-tag is-required">
                                    <i class="bi bi-upload"></i> Evidencia requerida
                                </span>
                            </div>
                        </div>
                    </div>

                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="exercise-purpose">
                    <div class="exercise-purpose-title">¿Para qué sirve?</div>
                    <div class="exercise-purpose-text">
                        Ayuda a desarrollar fuerza base en piernas, activar glúteo y mejorar el patrón de sentadilla.
                    </div>
                </div>
            </div>
        </button>

        {{-- 2 --}}
        <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#modalHipThrust">
            <div class="exercise-card">
                <div class="exercise-card-head">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="exercise-thumb">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Hip Thrust</div>
                            <div class="exercise-sub">4 series x 10 repeticiones · descanso 60s</div>

                            <div class="exercise-tags">
                                <span class="exercise-tag is-coach">
                                    <i class="bi bi-camera-video"></i> GIF / video del coach
                                </span>
                                <span class="exercise-tag is-required">
                                    <i class="bi bi-upload"></i> Evidencia requerida
                                </span>
                            </div>
                        </div>
                    </div>

                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="exercise-purpose">
                    <div class="exercise-purpose-title">¿Para qué sirve?</div>
                    <div class="exercise-purpose-text">
                        Se enfoca en glúteo mayor, mejora fuerza de cadera y ayuda a generar potencia.
                    </div>
                </div>
            </div>
        </button>

        {{-- 3 --}}
        <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#modalZancadas">
            <div class="exercise-card">
                <div class="exercise-card-head">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="exercise-thumb">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Zancadas Caminando</div>
                            <div class="exercise-sub">3 series x 12 pasos por pierna</div>

                            <div class="exercise-tags">
                                <span class="exercise-tag is-coach">
                                    <i class="bi bi-camera-video"></i> Demo del coach
                                </span>
                            </div>
                        </div>
                    </div>

                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="exercise-purpose">
                    <div class="exercise-purpose-title">¿Para qué sirve?</div>
                    <div class="exercise-purpose-text">
                        Mejora estabilidad, equilibrio y trabajo unilateral de piernas y glúteo.
                    </div>
                </div>
            </div>
        </button>

        {{-- 4 --}}
        <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#modalPesoMuerto">
            <div class="exercise-card">
                <div class="exercise-card-head">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="exercise-thumb">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Peso Muerto Rumano</div>
                            <div class="exercise-sub">4 series x 10 repeticiones</div>

                            <div class="exercise-tags">
                                <span class="exercise-tag is-coach">
                                    <i class="bi bi-camera-video"></i> Video del coach
                                </span>
                            </div>
                        </div>
                    </div>

                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="exercise-purpose">
                    <div class="exercise-purpose-title">¿Para qué sirve?</div>
                    <div class="exercise-purpose-text">
                        Fortalece femorales, glúteos y cadena posterior, además de mejorar control de cadera.
                    </div>
                </div>
            </div>
        </button>

        {{-- 5 --}}
        <button type="button" class="exercise-card-btn" data-bs-toggle="modal" data-bs-target="#modalAbduccion">
            <div class="exercise-card">
                <div class="exercise-card-head">
                    <div class="d-flex gap-3 flex-grow-1">
                        <div class="exercise-thumb">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="exercise-title">Abducción con Banda</div>
                            <div class="exercise-sub">3 series x 20 repeticiones</div>

                            <div class="exercise-tags">
                                <span class="exercise-tag is-coach">
                                    <i class="bi bi-camera-video"></i> GIF del coach
                                </span>
                            </div>
                        </div>
                    </div>

                    <i class="bi bi-chevron-right text-muted"></i>
                </div>

                <div class="exercise-purpose">
                    <div class="exercise-purpose-title">¿Para qué sirve?</div>
                    <div class="exercise-purpose-text">
                        Activa glúteo medio, mejora estabilidad de rodilla y ayuda al control lateral de cadera.
                    </div>
                </div>
            </div>
        </button>
    </div>
</div>

{{-- MODAL 1 --}}
<div class="modal fade modal-fitapp" id="modalSentadillaGoblet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Sentadilla Goblet</h5>
                    <div class="small text-muted">4 series x 12 repeticiones</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="exercise-demo-box mb-3">
                    <div>
                        <i class="bi bi-play-circle-fill"></i>
                        <div class="fw-bold mb-1">Aquí va el video o GIF del coach</div>
                        <div class="small text-muted">
                            Luego aquí reemplazas este bloque por un
                            <code>&lt;video controls&gt;</code>
                            o por un
                            <code>&lt;img src="gif..."&gt;</code>
                        </div>
                    </div>
                </div>

                <div class="section-title-row">
                    <h6 class="fw-bold mb-0">¿Para qué sirve?</h6>
                </div>
                <p class="fit-subtitle mb-3">
                    Mejora la mecánica de sentadilla, fortalece piernas completas y activa glúteo de forma segura.
                </p>

                <div class="surface-card p-3 mb-3">
                    <div class="fw-bold mb-2">Puntos clave del coach</div>
                    <ul class="exercise-info-list mb-0">
                        <li>Pecho arriba en todo el movimiento</li>
                        <li>Rodillas alineadas con pies</li>
                        <li>Bajar con control, sin colapsar la espalda</li>
                    </ul>
                </div>

                <div class="exercise-evidence-box">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                        <div>
                            <div class="fw-bold">Evidencia requerida</div>
                            <div class="small text-muted">Sube un video corto de una serie completa.</div>
                        </div>
                        <span class="status-pill status-warn">Pendiente</span>
                    </div>

                    <button class="btn btn-primary-custom w-100">
                        Subir video de este ejercicio
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 2 --}}
<div class="modal fade modal-fitapp" id="modalHipThrust" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Hip Thrust</h5>
                    <div class="small text-muted">4 series x 10 repeticiones</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="exercise-demo-box mb-3">
                    <div>
                        <i class="bi bi-camera-reels"></i>
                        <div class="fw-bold mb-1">GIF o video del coach</div>
                        <div class="small text-muted">
                            Ideal para mostrar rango correcto y bloqueo de cadera arriba.
                        </div>
                    </div>
                </div>

                <div class="surface-card p-3 mb-3">
                    <div class="fw-bold mb-2">¿Qué trabaja?</div>
                    <div class="fit-subtitle">
                        Glúteo mayor principalmente, además de apoyo en femorales y estabilidad pélvica.
                    </div>
                </div>

                <div class="surface-card p-3 mb-3">
                    <div class="fw-bold mb-2">Errores comunes</div>
                    <ul class="exercise-info-list mb-0">
                        <li>Empujar con la espalda baja en vez de la cadera</li>
                        <li>No completar el bloqueo arriba</li>
                        <li>Perder control al bajar</li>
                    </ul>
                </div>

                <div class="exercise-evidence-box">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                        <div>
                            <div class="fw-bold">Evidencia requerida</div>
                            <div class="small text-muted">Graba una serie para revisar rango y postura.</div>
                        </div>
                        <span class="status-pill status-warn">Pendiente</span>
                    </div>

                    <button class="btn btn-primary-custom w-100">
                        Subir video de este ejercicio
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 3 --}}
<div class="modal fade modal-fitapp" id="modalZancadas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Zancadas Caminando</h5>
                    <div class="small text-muted">3 series x 12 pasos por pierna</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="exercise-demo-box mb-3">
                    <div>
                        <i class="bi bi-play-circle-fill"></i>
                        <div class="fw-bold mb-1">Demo del coach</div>
                        <div class="small text-muted">Aquí puedes mostrar el paso correcto y la alineación de rodilla.</div>
                    </div>
                </div>

                <div class="surface-card p-3">
                    <div class="fw-bold mb-2">¿Para qué sirve?</div>
                    <div class="fit-subtitle">
                        Mejora fuerza unilateral, equilibrio y estabilidad en cadera, rodilla y tobillo.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 4 --}}
<div class="modal fade modal-fitapp" id="modalPesoMuerto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Peso Muerto Rumano</h5>
                    <div class="small text-muted">4 series x 10 repeticiones</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="exercise-demo-box mb-3">
                    <div>
                        <i class="bi bi-film"></i>
                        <div class="fw-bold mb-1">Video del coach</div>
                        <div class="small text-muted">Ideal para mostrar bisagra de cadera correcta.</div>
                    </div>
                </div>

                <div class="surface-card p-3">
                    <div class="fw-bold mb-2">¿Para qué sirve?</div>
                    <div class="fit-subtitle">
                        Fortalece cadena posterior y enseña a mover la cadera sin cargar la espalda baja.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 5 --}}
<div class="modal fade modal-fitapp" id="modalAbduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Abducción con Banda</h5>
                    <div class="small text-muted">3 series x 20 repeticiones</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="exercise-demo-box mb-3">
                    <div>
                        <i class="bi bi-image"></i>
                        <div class="fw-bold mb-1">GIF del coach</div>
                        <div class="small text-muted">Perfecto para mostrar activación controlada y postura.</div>
                    </div>
                </div>

                <div class="surface-card p-3">
                    <div class="fw-bold mb-2">¿Para qué sirve?</div>
                    <div class="fit-subtitle">
                        Activa glúteo medio y ayuda a mejorar la estabilidad lateral en pierna y cadera.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_nav')
    @include('fitapp.partials.bottom-nav')
@endsection
