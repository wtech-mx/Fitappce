@extends('layouts.fitapp-admin')

@section('title', 'Detalle de ejercicio | FitCoach Admin')

@section('content')
@php
    $parents = ['Tren superior', 'Tren inferior', 'Core'];
    $categories = ['Espalda', 'Pecho', 'Pierna', 'Glúteo'];
    $subcategories = ['Activación', 'Hip Thrust', 'Aislamiento', 'Remos', 'Jalones'];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Detalle / edición de ejercicio</h1>
        <div class="admin-topbar-subtitle">
            Vista visual para editar contenido, clasificación y comportamiento del ejercicio dentro de rutinas.
        </div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom px-4">
            Volver a biblioteca
        </a>
        <button class="btn btn-primary-custom px-4">
            Guardar cambios
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-detail-layout">
    {{-- COLUMNA PRINCIPAL --}}
    <div class="admin-section-stack">
        {{-- DATOS GENERALES --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos generales</h2>
                <div class="admin-mini">Información principal del ejercicio</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del ejercicio</label>
                        <input type="text" class="form-control input-soft" value="Hip Thrust">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nivel</label>
                        <select class="form-select input-soft">
                            <option>Principiante</option>
                            <option selected>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Categoría padre</label>
                        <select class="form-select input-soft">
                            @foreach($parents as $parent)
                                <option {{ $parent === 'Tren inferior' ? 'selected' : '' }}>{{ $parent }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Categoría</label>
                        <select class="form-select input-soft">
                            @foreach($categories as $cat)
                                <option {{ $cat === 'Glúteo' ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Subcategoría</label>
                        <select class="form-select input-soft">
                            @foreach($subcategories as $sub)
                                <option {{ $sub === 'Hip Thrust' ? 'selected' : '' }}>{{ $sub }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Descripción breve</label>
                        <textarea class="form-control input-soft py-3" rows="4">Ejercicio base para desarrollar glúteo, mejorar fuerza de cadera y generar potencia en tren inferior.</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENIDO TÉCNICO --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Contenido técnico</h2>
                <div class="admin-mini">Texto que luego verá el usuario dentro de la rutina</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">¿Para qué sirve?</label>
                        <textarea class="form-control input-soft py-3" rows="3">Sirve para trabajar principalmente glúteo mayor, mejorar extensión de cadera y desarrollar potencia.</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Músculos trabajados</label>
                        <input type="text" class="form-control input-soft" value="Glúteo mayor, femoral, estabilización de core">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Indicaciones del coach</label>
                        <textarea class="form-control input-soft py-3" rows="4">Mantén barbilla ligeramente hacia abajo, empuja desde talones y completa el bloqueo de cadera arriba sin arquear la espalda.</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Errores comunes</label>
                        <textarea class="form-control input-soft py-3" rows="4">Empujar con espalda baja, abrir costillas arriba, bajar sin control y usar un rango incompleto.</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- MULTIMEDIA --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Multimedia demo</h2>
                <div class="admin-mini">GIF o video que el usuario verá al abrir el ejercicio</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tipo de demo</label>
                        <select class="form-select input-soft">
                            <option>GIF</option>
                            <option selected>Video</option>
                            <option>Imagen</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Duración sugerida</label>
                        <input type="text" class="form-control input-soft" value="15 seg">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Ruta o archivo demo</label>
                        <input type="text" class="form-control input-soft" placeholder="hip-thrust-demo.mp4">
                    </div>

                    <div class="col-12">
                        <div class="admin-dropzone">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <div class="fw-bold mb-1">Subir video o GIF</div>
                            <div class="admin-mini">Solo visual por ahora. Después aquí entrará el upload real.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- COMPORTAMIENTO EN RUTINA --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Comportamiento dentro de rutinas</h2>
                <div class="admin-mini">Cómo se usará este ejercicio cuando el coach lo asigne</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-check-line">
                    <div>
                        <div class="fw-bold">Permitir evidencia del usuario</div>
                        <div class="admin-mini">Este ejercicio podrá marcarse para que el usuario suba video individual.</div>
                    </div>
                    <div class="admin-toggle-demo is-on"></div>
                </div>

                <div class="soft-divider"></div>

                <div class="admin-check-line">
                    <div>
                        <div class="fw-bold">Visible en biblioteca</div>
                        <div class="admin-mini">El ejercicio aparece disponible para reutilizarse en nuevas rutinas.</div>
                    </div>
                    <div class="admin-toggle-demo is-on"></div>
                </div>

                <div class="soft-divider"></div>

                <div class="admin-check-line">
                    <div>
                        <div class="fw-bold">Ejercicio destacado</div>
                        <div class="admin-mini">Puede resaltarse visualmente dentro de una rutina especial.</div>
                    </div>
                    <div class="admin-toggle-demo"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA / PREVIEW --}}
    <div class="admin-sticky-col">
        <div class="admin-preview-card">
            <div class="admin-preview-cover"></div>
            <div class="admin-preview-body">
                <div class="admin-detail-tags mb-3">
                    <span class="admin-tag">Tren inferior</span>
                    <span class="admin-tag">Glúteo</span>
                    <span class="admin-tag blue">Hip Thrust</span>
                </div>

                <div class="admin-card-title mb-1">Hip Thrust</div>
                <div class="admin-card-text mb-3">Intermedio · Video demo · Evidencia permitida</div>

                <div class="admin-text-block">
                    Ejercicio base para glúteo, útil para fuerza de cadera, potencia y progreso en rutinas de tren inferior.
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Vista previa multimedia</h2>
                <div class="admin-mini">Así se vería el bloque demo</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-media-preview">
                    <div>
                        <i class="bi bi-play-circle-fill"></i>
                        <div class="fw-bold mb-1">Aquí cargaría el video o GIF</div>
                        <div class="admin-mini">Después esto cambia por un video real o imagen GIF.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen rápido</h2>
                <div class="admin-mini">Chequeo visual del ejercicio</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <div class="value">1</div>
                        <div class="label">Categoría padre</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <div class="value">1</div>
                        <div class="label">Subcategoría</div>
                    </div>
                </div>

                <div class="fw-bold mb-2">Músculos trabajados</div>
                <ul class="admin-mini-list mb-3">
                    <li>Glúteo mayor</li>
                    <li>Femoral</li>
                    <li>Estabilidad de core</li>
                </ul>

                <div class="fw-bold mb-2">Errores comunes</div>
                <ul class="admin-mini-list mb-0">
                    <li>Arquear la espalda arriba</li>
                    <li>No bloquear cadera</li>
                    <li>Bajar sin control</li>
                </ul>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Tip de estructura</div>
            <div class="admin-mini">
                Más adelante esta vista puede servir tanto para <strong>crear</strong> como para <strong>editar</strong>, cambiando solo los datos cargados.
            </div>
        </div>
    </div>
</div>
@endsection
