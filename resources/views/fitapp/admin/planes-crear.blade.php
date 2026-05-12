@extends('layouts.fitapp-admin')

@section('title', 'Crear plan | FitCoach Admin')

@section('content')
@php
    $routines = [
        ['name' => 'Masa muscular - Intermedio', 'meta' => '4 dias - 4 semanas', 'tag' => 'Hipertrofia'],
        ['name' => 'Definicion - Casa', 'meta' => '3 dias - 6 semanas', 'tag' => 'Deficit'],
        ['name' => 'Gluteo Volumen', 'meta' => '2 dias - gimnasio', 'tag' => 'Personalizado'],
        ['name' => 'Superior tecnico', 'meta' => '1 dia - gimnasio', 'tag' => 'Complemento'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Crear plan</h1>
        <div class="admin-topbar-subtitle">Define si el plan sera predefinido o personalizado, luego conecta las rutinas que lo forman.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.planes') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button class="btn btn-primary-custom px-4">Guardar plan</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="routine-builder-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos generales</h2>
                <div class="admin-mini">Esta informacion aparecera al asignar el plan a un usuario.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label fw-bold">Nombre del plan</label>
                        <input type="text" class="form-control input-soft" value="Masa muscular - Base 8 semanas">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Tipo de plan</label>
                        <select class="form-select input-soft">
                            <option selected>Predefinido</option>
                            <option>Personalizado mensual</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo</label>
                        <select class="form-select input-soft">
                            <option selected>Aumento de masa muscular</option>
                            <option>Disminuir grasa corporal</option>
                            <option>Capacidad fisica condicional</option>
                            <option>Recomposicion corporal</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Duracion</label>
                        <select class="form-select input-soft">
                            <option>4 semanas</option>
                            <option selected>8 semanas</option>
                            <option>12 semanas</option>
                            <option>Mensual renovable</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select input-soft">
                            <option>Borrador</option>
                            <option selected>Activo</option>
                            <option>Plantilla</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Descripcion del plan</label>
                        <textarea class="form-control input-soft py-3" rows="4">Plan base para aumentar masa muscular con progresion de cargas, tecnica limpia y evidencias en ejercicios clave.</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Rutinas dentro del plan</h2>
                        <div class="admin-mini">Un plan puede usar una rutina completa o varias rutinas por semanas.</div>
                    </div>
                    <button class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Agregar rutina</button>
                </div>
            </div>

            <div class="admin-form-card-body">
                <div class="routine-exercise-list">
                    <div class="routine-exercise-row">
                        <div class="routine-order">1</div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Masa muscular - Intermedio</div>
                                    <div class="admin-mini">Semanas 1 a 4 - 4 dias por semana</div>
                                </div>
                                <span class="admin-tag blue">Rutina base</span>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Inicio</span><strong>Semana 1</strong></div>
                                <div><span>Fin</span><strong>Semana 4</strong></div>
                                <div><span>Dias</span><strong>4</strong></div>
                                <div><span>Lugar</span><strong>Gimnasio</strong></div>
                                <div><span>Evidencias</span><strong>7</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="routine-exercise-row is-superset">
                        <div class="routine-order">2</div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Gluteo Volumen</div>
                                    <div class="admin-mini">Semanas 5 a 8 - ajuste por objetivo</div>
                                </div>
                                <span class="admin-tag yellow">Progresion</span>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Inicio</span><strong>Semana 5</strong></div>
                                <div><span>Fin</span><strong>Semana 8</strong></div>
                                <div><span>Dias</span><strong>2</strong></div>
                                <div><span>Lugar</span><strong>Gimnasio</strong></div>
                                <div><span>Evidencias</span><strong>4</strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="routine-add-block">
                    <i class="bi bi-plus-circle"></i>
                    <div>
                        <div class="fw-bold">Agregar otra rutina</div>
                        <div class="admin-mini">Selecciona una rutina ya creada y define en que semana entra.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Reglas para personalizados</h2>
                <div class="admin-mini">Sirve para dejar claro que el plan cambia segun progreso mensual.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Revision</label>
                        <select class="form-select input-soft">
                            <option selected>Mensual</option>
                            <option>Cada 2 semanas</option>
                            <option>Solo al finalizar</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Requiere medidas</label>
                        <select class="form-select input-soft">
                            <option selected>Si</option>
                            <option>No</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Requiere evidencias</label>
                        <select class="form-select input-soft">
                            <option selected>Si</option>
                            <option>Opcional</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Notas internas</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Ajustes esperados, criterios de cambio y observaciones para el coach."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Biblioteca de rutinas</h2>
                <div class="admin-mini">Seleccion simulada desde rutinas existentes.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-search mb-3">
                    <input type="text" class="form-control input-soft" placeholder="Buscar rutina...">
                </div>

                <div class="routine-library-list">
                    @foreach($routines as $routine)
                        <div class="routine-library-item">
                            <div class="admin-thumb">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-bold">{{ $routine['name'] }}</div>
                                <div class="admin-mini">{{ $routine['meta'] }} - {{ $routine['tag'] }}</div>
                            </div>
                            <button class="admin-icon-btn"><i class="bi bi-plus"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Jerarquia visual</div>
            <div class="admin-mini">
                Plan -> Rutinas -> Dias -> Ejercicios. En backend, esta pantalla guardara solo la composicion del plan.
            </div>
        </div>
    </div>
</div>
@endsection
