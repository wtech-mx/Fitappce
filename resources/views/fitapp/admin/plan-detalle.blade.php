@extends('layouts.fitapp-admin')

@section('title', 'Detalle de plan | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Masa muscular - Base 8 semanas</h1>
        <div class="admin-topbar-subtitle">Plan predefinido creado a partir de rutinas. Listo para asignar a usuarios con objetivo compatible.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.planes') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.planes.crear') }}" class="btn btn-primary-custom px-4">Editar plan</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen del plan</h2>
                <div class="admin-mini">Datos clave antes de asignarlo.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-summary-grid">
                    <div><span>Tipo</span><strong>Predefinido</strong></div>
                    <div><span>Objetivo</span><strong>Masa muscular</strong></div>
                    <div><span>Duracion</span><strong>8 semanas</strong></div>
                    <div><span>Usuarios</span><strong>12 activos</strong></div>
                </div>
                <div class="routine-note mt-3">
                    Este plan tiene un limite fijo por objetivo. El usuario lo sigue durante 8 semanas y despues puede pasar a otro plan o a personalizado mensual.
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Estructura por semanas</h2>
                <div class="admin-mini">Rutinas conectadas al plan.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-exercise-list">
                    <div class="routine-exercise-row">
                        <div class="routine-order">1-4</div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Rutina: Masa muscular - Intermedio</div>
                                    <div class="admin-mini">Lunes pierna, martes espalda, jueves pecho, viernes gluteo</div>
                                </div>
                                <a href="{{ route('fitapp.admin.rutinas.detalle') }}" class="admin-btn-soft">Ver rutina</a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Dias</span><strong>4</strong></div>
                                <div><span>Ejercicios</span><strong>18</strong></div>
                                <div><span>Biseries</span><strong>3</strong></div>
                                <div><span>Evidencias</span><strong>7</strong></div>
                                <div><span>Proposito</span><strong>Base</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="routine-exercise-row is-superset">
                        <div class="routine-order">5-8</div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Rutina: Gluteo Volumen</div>
                                    <div class="admin-mini">Bloque de progresion para reforzar objetivo estetico</div>
                                </div>
                                <a href="{{ route('fitapp.admin.rutinas.detalle') }}" class="admin-btn-soft">Ver rutina</a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Dias</span><strong>2</strong></div>
                                <div><span>Ejercicios</span><strong>10</strong></div>
                                <div><span>Biseries</span><strong>2</strong></div>
                                <div><span>Evidencias</span><strong>4</strong></div>
                                <div><span>Proposito</span><strong>Volumen</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Usuarios asignados</h2>
                <span class="small text-muted">Demo visual</span>
            </div>
            <div class="admin-panel-body">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Inicio</th>
                                <th>Semana</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>María González</strong><div class="small text-muted">Rutina + nutricion</div></td>
                                <td>01 Abr</td>
                                <td>2 de 8</td>
                                <td><span class="admin-tag blue">Activo</span></td>
                                <td><a href="{{ route('fitapp.admin.usuarios') }}" class="admin-btn-soft">Perfil</a></td>
                            </tr>
                            <tr>
                                <td><strong>Adrián López</strong><div class="small text-muted">Solo entrenamiento</div></td>
                                <td>15 Abr</td>
                                <td>1 de 8</td>
                                <td><span class="admin-tag yellow">Nuevo</span></td>
                                <td><a href="{{ route('fitapp.admin.usuarios') }}" class="admin-btn-soft">Perfil</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Asignar plan</h2>
                <div class="admin-mini">Seleccion visual para preparar asignacion.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Usuario</label>
                    <input type="text" class="form-control input-soft" placeholder="Buscar usuario">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de inicio</label>
                    <input type="text" class="form-control input-soft" value="15 abril 2026">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Incluye nutricion</label>
                    <select class="form-select input-soft">
                        <option>Si, plan completo</option>
                        <option>No, solo rutina</option>
                    </select>
                </div>
                <button class="btn btn-primary-custom w-100">Asignar a usuario</button>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Diferencia clave</div>
            <div class="admin-mini">
                Un plan predefinido se asigna tal cual. Un personalizado debe renovarse cada mes usando evidencias, medidas y notas del coach.
            </div>
        </div>
    </div>
</div>
@endsection
