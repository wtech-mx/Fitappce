@extends('layouts.fitapp-admin')

@section('title', 'Crear estructura de ejercicios | FitCoach Admin')

@section('content')
@php
    $parents = ['Tren superior', 'Tren inferior', 'Core'];
    $categories = ['Espalda', 'Pecho', 'Pierna', 'Glúteo'];
    $subcategories = ['Activación', 'Hip Thrust', 'Aislamiento', 'Remos', 'Jalones'];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Crear estructura</h1>
        <div class="admin-topbar-subtitle">
            Aquí el coach puede crear categorías padre, categorías, subcategorías y ejercicios. Todo visual por ahora.
        </div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom px-4">
            Volver a biblioteca
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-create-layout">
    <div class="d-flex flex-column gap-3">
        {{-- CREAR CATEGORÍA PADRE --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">1. Crear categoría padre</h2>
                <div class="admin-mini">Ejemplo: Tren superior, Tren inferior, Core</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Tren inferior">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select input-soft">
                            <option>Activa</option>
                            <option>Oculta</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary-custom">Guardar categoría padre</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREAR CATEGORÍA --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">2. Crear categoría</h2>
                <div class="admin-mini">Ejemplo: Glúteo, Espalda, Pecho</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoría padre</label>
                        <select class="form-select input-soft">
                            @foreach($parents as $parent)
                                <option>{{ $parent }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de categoría</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Glúteo">
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary-custom">Guardar categoría</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREAR SUBCATEGORÍA --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">3. Crear subcategoría</h2>
                <div class="admin-mini">Ejemplo: Activación, Hip Thrust, Aislamiento</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoría padre</label>
                        <select class="form-select input-soft">
                            @foreach($parents as $parent)
                                <option>{{ $parent }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Categoría</label>
                        <select class="form-select input-soft">
                            @foreach($categories as $cat)
                                <option>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Nombre de subcategoría</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Activación">
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary-custom">Guardar subcategoría</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREAR EJERCICIO --}}
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">4. Crear ejercicio</h2>
                <div class="admin-mini">Asignado a categoría padre, categoría y subcategoría</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Categoría padre</label>
                        <select class="form-select input-soft">
                            @foreach($parents as $parent)
                                <option>{{ $parent }}</option>
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
                                <option>{{ $sub }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre del ejercicio</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Hip Thrust">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nivel</label>
                        <select class="form-select input-soft">
                            <option>Principiante</option>
                            <option>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Descripción breve</label>
                        <textarea class="form-control input-soft py-3" rows="4" placeholder="Describe para qué sirve el ejercicio y qué trabaja."></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">GIF / video demo</label>
                        <input type="text" class="form-control input-soft" placeholder="Ruta o archivo demo">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Grupo muscular principal</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Glúteo mayor">
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary-custom">Guardar ejercicio</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PREVIEW --}}
    <div class="d-flex flex-column gap-3">
        <div class="admin-preview-card">
            <div class="admin-preview-cover"></div>
            <div class="admin-preview-body">
                <div class="admin-card-title">Vista previa del ejercicio</div>
                <div class="admin-card-text mb-3">
                    Así se vería una card dentro de la biblioteca cuando el coach agregue el ejercicio.
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="admin-tag">Tren inferior</span>
                    <span class="admin-tag">Glúteo</span>
                    <span class="admin-tag blue">Hip Thrust</span>
                </div>

                <div class="fw-bold mb-1">Hip Thrust</div>
                <div class="admin-card-text">
                    Ejercicio base para desarrollar glúteo, mejorar fuerza de cadera y generar potencia.
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen actual</h2>
                <div class="admin-mini">Demo visual</div>
            </div>
            <div class="admin-form-card-body">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="admin-count-badge">3 categorías padre</span>
                    <span class="admin-count-badge">4 categorías</span>
                    <span class="admin-count-badge">5 subcategorías</span>
                </div>

                <div class="admin-helper-note">
                    <div class="fw-bold mb-1">Cómo queda la jerarquía</div>
                    <div class="admin-mini">
                        Categoría padre → Categoría → Subcategoría → Ejercicio
                    </div>
                </div>

                <div class="mt-3">
                    <ul class="info-list mb-0">
                        <li>Tren inferior → Glúteo → Activación</li>
                        <li>Tren inferior → Glúteo → Hip Thrust</li>
                        <li>Tren superior → Espalda → Jalones</li>
                        <li>Tren superior → Espalda → Remos</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
