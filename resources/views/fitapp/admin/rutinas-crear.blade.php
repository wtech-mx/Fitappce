@extends('layouts.fitapp-admin')

@section('title', 'Crear rutina | FitCoach Admin')

@section('content')
@php
    $library = [
        ['name' => 'Hip Thrust', 'group' => 'Tren inferior / Gluteo', 'level' => 'Intermedio'],
        ['name' => 'Sentadilla Goblet', 'group' => 'Tren inferior / Pierna', 'level' => 'Principiante'],
        ['name' => 'Peso Muerto Rumano', 'group' => 'Tren inferior / Femoral', 'level' => 'Intermedio'],
        ['name' => 'Abduccion con Banda', 'group' => 'Tren inferior / Gluteo', 'level' => 'Principiante'],
        ['name' => 'Remo con Mancuerna', 'group' => 'Tren superior / Espalda', 'level' => 'Intermedio'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Crear rutina</h1>
        <div class="admin-topbar-subtitle">Arma el plan desde ejercicios existentes: objetivo, bloques, descansos, biseries y evidencias.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.rutinas') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button class="btn btn-primary-custom px-4">Guardar rutina</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="routine-builder-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos generales</h2>
                <div class="admin-mini">Base que luego se asigna a usuario o plantilla</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nombre de la rutina</label>
                        <input type="text" class="form-control input-soft" value="Masa muscular - Intermedio">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nivel</label>
                        <select class="form-select input-soft">
                            <option>Principiante</option>
                            <option selected>Intermedio</option>
                            <option>Avanzado</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Duracion</label>
                        <select class="form-select input-soft">
                            <option>4 semanas</option>
                            <option>6 semanas</option>
                            <option>8 semanas</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Objetivo</label>
                        <select class="form-select input-soft">
                            <option selected>Masa muscular</option>
                            <option>Definicion</option>
                            <option>Fuerza</option>
                            <option>Adulto mayor</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Lugar</label>
                        <select class="form-select input-soft">
                            <option selected>Gimnasio</option>
                            <option>Casa</option>
                            <option>Mixto</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dias por semana</label>
                        <select class="form-select input-soft">
                            <option>3 dias</option>
                            <option selected>4 dias</option>
                            <option>5 dias</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Proposito de la rutina</label>
                        <textarea class="form-control input-soft py-3" rows="3">Desarrollar masa muscular con enfoque en progresion de cargas, tecnica limpia y evidencias en ejercicios clave.</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Dias de entrenamiento</h2>
                        <div class="admin-mini">Cada dia puede tener ejercicios individuales, biseries o circuitos</div>
                    </div>
                    <button class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Agregar dia</button>
                </div>
            </div>

            <div class="admin-form-card-body">
                <div class="routine-day-card">
                    <div class="routine-day-head">
                        <div>
                            <div class="admin-card-title mb-1">Dia 1 - Pierna y gluteo</div>
                            <div class="admin-mini">Enfoque: fuerza de cadera, cuadriceps y tecnica</div>
                        </div>
                        <span class="admin-tag blue">5 ejercicios</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Dia</label>
                            <select class="form-select input-soft">
                                <option selected>Lunes</option>
                                <option>Martes</option>
                                <option>Miercoles</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Grupo principal</label>
                            <input type="text" class="form-control input-soft" value="Pierna y gluteo">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tiempo estimado</label>
                            <input type="text" class="form-control input-soft" value="60 min">
                        </div>
                    </div>

                    <div class="routine-exercise-list">
                        <div class="routine-exercise-row">
                            <div class="routine-order">1</div>
                            <div class="routine-exercise-main">
                                <div class="d-flex justify-content-between gap-3 mb-2">
                                    <div>
                                        <div class="fw-bold">Hip Thrust</div>
                                        <div class="admin-mini">Tren inferior / Gluteo / Hip Thrust</div>
                                    </div>
                                    <span class="admin-tag blue">Evidencia</span>
                                </div>

                                <div class="routine-prescription-grid">
                                    <div><span>Bloque</span><strong>Individual</strong></div>
                                    <div><span>Series</span><strong>4</strong></div>
                                    <div><span>Reps</span><strong>10-12</strong></div>
                                    <div><span>Descanso</span><strong>90 seg</strong></div>
                                    <div><span>Tempo</span><strong>2-1-2</strong></div>
                                </div>

                                <div class="routine-note mt-3">Proposito: ejercicio base para fuerza de cadera y desarrollo de gluteo. Video obligatorio para revisar tecnica.</div>
                            </div>
                        </div>

                        <div class="routine-exercise-row is-superset">
                            <div class="routine-order">2A</div>
                            <div class="routine-exercise-main">
                                <div class="d-flex justify-content-between gap-3 mb-2">
                                    <div>
                                        <div class="fw-bold">Sentadilla Goblet + Abduccion con Banda</div>
                                        <div class="admin-mini">Biserie: fuerza + activacion</div>
                                    </div>
                                    <span class="admin-tag yellow">Biserie</span>
                                </div>

                                <div class="routine-prescription-grid">
                                    <div><span>Bloque</span><strong>Biserie</strong></div>
                                    <div><span>Series</span><strong>3</strong></div>
                                    <div><span>Reps</span><strong>12 + 20</strong></div>
                                    <div><span>Descanso</span><strong>75 seg al final</strong></div>
                                    <div><span>Intensidad</span><strong>RPE 8</strong></div>
                                </div>

                                <div class="routine-note mt-3">El usuario realiza ambos ejercicios seguidos y descansa al terminar la pareja.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="routine-add-block">
                    <i class="bi bi-plus-circle"></i>
                    <div>
                        <div class="fw-bold">Agregar ejercicio o bloque</div>
                        <div class="admin-mini">Selecciona desde la biblioteca y define si sera individual, biserie o circuito.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Biblioteca de ejercicios</h2>
                <div class="admin-mini">Seleccion simulada para armar la rutina</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-search mb-3">
                    <input type="text" class="form-control input-soft" placeholder="Buscar ejercicio...">
                </div>

                <div class="routine-library-list">
                    @foreach($library as $exercise)
                        <div class="routine-library-item">
                            <div class="admin-thumb">
                                <i class="bi bi-camera-reels"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-bold">{{ $exercise['name'] }}</div>
                                <div class="admin-mini">{{ $exercise['group'] }} - {{ $exercise['level'] }}</div>
                            </div>
                            <button class="admin-icon-btn"><i class="bi bi-plus"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Configuracion rapida</h2>
                <div class="admin-mini">Valores por defecto para nuevos bloques</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Descanso base</label>
                        <input type="text" class="form-control input-soft" value="75 seg">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Series base</label>
                        <input type="text" class="form-control input-soft" value="3">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Evidencia por defecto</label>
                        <select class="form-select input-soft">
                            <option>Solo ejercicios marcados</option>
                            <option>Todos los ejercicios base</option>
                            <option>Ninguna</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Como se conectara despues</div>
            <div class="admin-mini">
                Cada bloque guardara ejercicio_id, tipo de bloque, orden, series, repeticiones, descanso, tempo, indicaciones y si requiere evidencia.
            </div>
        </div>
    </div>
</div>
@endsection
