@extends('layouts.fitapp-admin')

@section('title', 'Perfil de usuario | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">María González</h1>
        <div class="admin-topbar-subtitle">Expediente visual del usuario: onboarding, planes, nutricion, medidas, pagos y evidencias.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios') }}" class="btn btn-soft-custom px-4">Volver</a>
        <a href="{{ route('fitapp.admin.planes') }}" class="btn btn-primary-custom px-4">Asignar plan</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="admin-panel-title mb-1">Perfil general</h2>
                        <div class="admin-mini">Datos base para seguimiento.</div>
                    </div>
                    <span class="admin-tag blue">Activa</span>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="d-flex gap-3 mb-3">
                    <div class="admin-avatar-lg">M</div>
                    <div>
                        <div class="admin-card-title">María González</div>
                        <div class="admin-card-text">maria@email.com - +52 000 000 0000</div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="admin-tag">Rutina + nutricion</span>
                            <span class="admin-tag yellow">Personalizado mensual</span>
                            <span class="admin-tag blue">Masa muscular</span>
                        </div>
                    </div>
                </div>

                <div class="routine-summary-grid">
                    <div><span>Nivel</span><strong>Intermedio</strong></div>
                    <div><span>Entrena</span><strong>Gimnasio</strong></div>
                    <div><span>Frecuencia</span><strong>4 dias</strong></div>
                    <div><span>Sesion</span><strong>60 min</strong></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Planes asignados</h2>
                <div class="admin-mini">Entrenamiento y alimentacion activos.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-exercise-list">
                    <div class="routine-exercise-row">
                        <div class="routine-order"><i class="bi bi-activity"></i></div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Personalizado mensual - Mes 2</div>
                                    <div class="admin-mini">Vigencia: 01 Abr a 30 Abr - cambio mensual segun progreso</div>
                                </div>
                                <a href="{{ route('fitapp.admin.planes.detalle') }}" class="admin-btn-soft">Ver plan</a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Rutinas</span><strong>3</strong></div>
                                <div><span>Dias</span><strong>5</strong></div>
                                <div><span>Evidencias</span><strong>9</strong></div>
                                <div><span>Estado</span><strong>Activo</strong></div>
                                <div><span>Renueva</span><strong>Mensual</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="routine-exercise-row is-superset">
                        <div class="routine-order"><i class="bi bi-cup-hot"></i></div>
                        <div class="routine-exercise-main">
                            <div class="d-flex justify-content-between gap-3 mb-2">
                                <div>
                                    <div class="fw-bold">Plan alimentario - 2168 kcal</div>
                                    <div class="admin-mini">5 comidas - 143.98g proteina - 3 litros de agua</div>
                                </div>
                                <a href="{{ route('fitapp.admin.nutricion') }}" class="admin-btn-soft">Ver nutricion</a>
                            </div>
                            <div class="routine-prescription-grid">
                                <div><span>Kcal</span><strong>2168</strong></div>
                                <div><span>Proteina</span><strong>143.98g</strong></div>
                                <div><span>Carbs</span><strong>266.35g</strong></div>
                                <div><span>Grasas</span><strong>64.25g</strong></div>
                                <div><span>Agua</span><strong>3L</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Medidas corporales</h2>
                <div class="admin-mini">Basado en el tipo de documento de valoracion y plan alimentario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="routine-summary-grid mb-3">
                    <div><span>Grasa corporal</span><strong>14.73%</strong></div>
                    <div><span>Masa magra</span><strong>55.681 kg</strong></div>
                    <div><span>Masa grasa</span><strong>9.619 kg</strong></div>
                    <div><span>Peso</span><strong>65.300 kg</strong></div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Medida</th>
                                <th>Valor</th>
                                <th>Meta</th>
                                <th>Cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Grasa corporal</td><td>14.73%</td><td>14.00%</td><td><span class="admin-tag blue">-0.73%</span></td></tr>
                            <tr><td>Cintura</td><td>81.20 cm</td><td>79.00 cm</td><td><span class="admin-tag yellow">Pendiente</span></td></tr>
                            <tr><td>Cadera</td><td>92.50 cm</td><td>94.00 cm</td><td><span class="admin-tag">Seguimiento</span></td></tr>
                            <tr><td>Brazo flexionado</td><td>33.80 cm</td><td>34.50 cm</td><td><span class="admin-tag">Seguimiento</span></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="admin-card-actions">
                    <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Nueva medicion</a>
                    <a href="{{ route('fitapp.admin.mediciones') }}" class="admin-btn-soft"><i class="bi bi-file-earmark-text"></i> Ver historial</a>
                    <a href="{{ route('fitapp.admin.mediciones.reporte') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Reporte visual</a>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Onboarding</h2>
                <div class="admin-mini">Respuestas iniciales del usuario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item"><div class="admin-list-row"><span>Objetivo</span><strong>Masa muscular</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Servicio</span><strong>Rutina + nutricion</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Plan</span><strong>Personalizado</strong></div></div>
                    <div class="admin-list-item"><div class="admin-list-row"><span>Restricciones</span><strong>Ninguna</strong></div></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Pendientes</h2>
                <div class="admin-mini">Acciones rapidas del coach.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Revisar video de hip thrust</div>
                                <div class="small text-muted">Evidencia enviada ayer</div>
                            </div>
                            <span class="admin-tag yellow">Pendiente</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Actualizar plan mes 3</div>
                                <div class="small text-muted">Vence el 30 de abril</div>
                            </div>
                            <span class="admin-tag red">Urgente</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Confirmar pago</div>
                                <div class="small text-muted">Mensualidad enviada por Mercado Pago</div>
                            </div>
                            <span class="admin-tag blue">Nuevo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Vista de expediente</div>
            <div class="admin-mini">
                Esta pantalla concentra todo lo que despues se guardara por usuario: datos, respuestas, planes, nutricion, medidas, evidencias y pagos.
            </div>
        </div>
    </div>
</div>
@endsection
