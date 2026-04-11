@extends('layouts.fitapp-admin')

@section('title', 'Dashboard Admin | FitCoach')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Dashboard administrativo</h1>
        <div class="admin-topbar-subtitle">Resumen general de citas, usuarios, evidencias y seguimiento.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.citas') }}" class="btn btn-primary-custom px-4">
            Ver agenda
        </a>
        <button class="admin-icon-btn" type="button">
            <i class="bi bi-bell"></i>
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Citas hoy</div>
        <div class="admin-stat-value">8</div>
        <div class="admin-stat-note">3 por confirmar · 5 activas</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Usuarios activos</div>
        <div class="admin-stat-value">64</div>
        <div class="admin-stat-note">+6 esta semana</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Evidencias pendientes</div>
        <div class="admin-stat-value">17</div>
        <div class="admin-stat-note">7 videos · 10 fotos</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Pagos por revisar</div>
        <div class="admin-stat-value">11</div>
        <div class="admin-stat-note">Mercado Pago y efectivo</div>
    </div>
</div>

<div class="admin-content-grid">
    <section class="admin-panel">
        <div class="admin-panel-head">
            <h2 class="admin-panel-title">Próximas citas</h2>
            <a href="{{ route('fitapp.admin.citas') }}" class="small text-decoration-none text-primary-custom">Abrir agenda</a>
        </div>

        <div class="admin-panel-body">
            <div class="admin-list">
                <div class="admin-list-item">
                    <div class="admin-list-row">
                        <div>
                            <div class="fw-bold">María González</div>
                            <div class="admin-mini">Valoración inicial · 11:00 AM</div>
                        </div>
                        <span class="admin-tag blue">Mercado Pago</span>
                    </div>
                </div>

                <div class="admin-list-item">
                    <div class="admin-list-row">
                        <div>
                            <div class="fw-bold">Jorge Ramírez</div>
                            <div class="admin-mini">Valoración inicial · 12:30 PM</div>
                        </div>
                        <span class="admin-tag yellow">Efectivo</span>
                    </div>
                </div>

                <div class="admin-list-item">
                    <div class="admin-list-row">
                        <div>
                            <div class="fw-bold">Karla Hernández</div>
                            <div class="admin-mini">Seguimiento nutricional · 04:00 PM</div>
                        </div>
                        <span class="admin-tag red">Pendiente confirmar</span>
                    </div>
                </div>

                <div class="admin-list-item">
                    <div class="admin-list-row">
                        <div>
                            <div class="fw-bold">Daniel Torres</div>
                            <div class="admin-mini">Revisión técnica · 06:00 PM</div>
                        </div>
                        <span class="admin-tag blue">Confirmada</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel-head">
            <h2 class="admin-panel-title">Pendientes rápidos</h2>
            <span class="small text-muted">Hoy</span>
        </div>

        <div class="admin-panel-body">
            <div class="admin-list">
                <div class="admin-list-item">
                    <div class="fw-bold mb-1">7 videos por revisar</div>
                    <div class="admin-mini">Ejercicios con evidencia marcada por el coach.</div>
                </div>

                <div class="admin-list-item">
                    <div class="fw-bold mb-1">10 fotos de comida pendientes</div>
                    <div class="admin-mini">Usuarios con plan nutricional activo.</div>
                </div>

                <div class="admin-list-item">
                    <div class="fw-bold mb-1">4 planes personalizados por cerrar</div>
                    <div class="admin-mini">Usuarios que ya fueron a valoración presencial.</div>
                </div>

                <div class="admin-list-item">
                    <div class="fw-bold mb-1">3 reservas con pago en efectivo</div>
                    <div class="admin-mini">Requieren validar asistencia en consultorio.</div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="admin-panel mt-3">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title">Actividad reciente</h2>
        <span class="small text-muted">Últimos movimientos</span>
    </div>

    <div class="admin-panel-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Evento</th>
                        <th>Hora</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>María González</td>
                        <td>Reservó cita inicial</td>
                        <td>09:14 AM</td>
                        <td><span class="admin-tag blue">Confirmada</span></td>
                    </tr>
                    <tr>
                        <td>Alan Pérez</td>
                        <td>Subió evidencia de Sentadilla Goblet</td>
                        <td>09:40 AM</td>
                        <td><span class="admin-tag yellow">Pendiente revisión</span></td>
                    </tr>
                    <tr>
                        <td>Fernanda Ruiz</td>
                        <td>Mandó foto de comida</td>
                        <td>10:05 AM</td>
                        <td><span class="admin-tag yellow">Pendiente</span></td>
                    </tr>
                    <tr>
                        <td>Jorge Ramírez</td>
                        <td>Seleccionó pago en efectivo</td>
                        <td>10:21 AM</td>
                        <td><span class="admin-tag red">Validar asistencia</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
