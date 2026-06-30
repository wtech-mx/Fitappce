@extends('layouts.fitapp-admin')

@section('title', 'Dashboard Admin | FitCoach')

@section('content')
<div class="admin-topbar dashboard-topbar">
    <div>
        <div class="page-kicker mb-2"><i class="bi bi-speedometer2"></i> Centro de control</div>
        <h1 class="admin-topbar-title">Dashboard administrativo</h1>
        <div class="admin-topbar-subtitle">Resumen general de citas, usuarios, evidencias y seguimiento.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.citas') }}" class="btn btn-primary-custom px-4 admin-action-btn">
            <i class="bi bi-calendar2-week"></i>
            <span>Ver agenda</span>
        </a>
        <a href="{{ route('fitapp.admin.usuarios.alta') }}" class="btn btn-soft-custom px-4 admin-action-btn">
            <i class="bi bi-person-plus"></i>
            <span>Nuevo usuario</span>
        </a>
        <button class="admin-icon-btn" type="button" aria-label="Notificaciones">
            <i class="bi bi-bell"></i>
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<section class="dashboard-hero">
    <div class="dashboard-hero-copy">
        <span class="dashboard-hero-icon"><i class="bi bi-activity"></i></span>
        <div>
            <h2>Operacion de hoy</h2>
            <p>Prioriza confirmaciones, evidencias y planes listos para entregar.</p>
        </div>
    </div>
    <div class="dashboard-hero-actions">
        <a href="{{ route('fitapp.admin.evidencias') }}" class="admin-pill-action"><i class="bi bi-camera-video"></i> Evidencias</a>
        <a href="{{ route('fitapp.admin.planes') }}" class="admin-pill-action"><i class="bi bi-clipboard2-pulse"></i> Planes</a>
        <a href="{{ route('fitapp.admin.pagos') }}" class="admin-pill-action"><i class="bi bi-cash-stack"></i> Pagos</a>
    </div>
</section>

<div class="admin-grid-cards dashboard-stat-grid">
    <a href="{{ route('fitapp.admin.citas') }}" class="admin-stat-card dashboard-stat-card">
        <div class="dashboard-stat-icon blue"><i class="bi bi-calendar-check"></i></div>
        <div>
            <div class="admin-stat-label">Citas hoy</div>
            <div class="admin-stat-value">8</div>
            <div class="admin-stat-note">3 por confirmar &middot; 5 activas</div>
        </div>
    </a>

    <a href="{{ route('fitapp.admin.usuarios') }}" class="admin-stat-card dashboard-stat-card">
        <div class="dashboard-stat-icon green"><i class="bi bi-people"></i></div>
        <div>
            <div class="admin-stat-label">Usuarios activos</div>
            <div class="admin-stat-value">64</div>
            <div class="admin-stat-note">+6 esta semana</div>
        </div>
    </a>

    <a href="{{ route('fitapp.admin.evidencias') }}" class="admin-stat-card dashboard-stat-card">
        <div class="dashboard-stat-icon yellow"><i class="bi bi-camera-video"></i></div>
        <div>
            <div class="admin-stat-label">Evidencias pendientes</div>
            <div class="admin-stat-value">17</div>
            <div class="admin-stat-note">7 videos &middot; 10 fotos</div>
        </div>
    </a>

    <a href="{{ route('fitapp.admin.pagos') }}" class="admin-stat-card dashboard-stat-card">
        <div class="dashboard-stat-icon red"><i class="bi bi-wallet2"></i></div>
        <div>
            <div class="admin-stat-label">Pagos por revisar</div>
            <div class="admin-stat-value">11</div>
            <div class="admin-stat-note">Mercado Pago y efectivo</div>
        </div>
    </a>
</div>

<div class="dashboard-quick-grid">
    <a href="{{ route('fitapp.admin.rutinas.crear') }}" class="dashboard-quick-card">
        <i class="bi bi-plus-circle"></i>
        <span>Crear rutina</span>
    </a>
    <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="dashboard-quick-card">
        <i class="bi bi-collection-play"></i>
        <span>Nuevo ejercicio</span>
    </a>
    <a href="{{ route('fitapp.admin.nutricion.crear') }}" class="dashboard-quick-card">
        <i class="bi bi-journal-medical"></i>
        <span>Plan nutricional</span>
    </a>
    <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="dashboard-quick-card">
        <i class="bi bi-rulers"></i>
        <span>Medicion</span>
    </a>
</div>

<div class="admin-content-grid dashboard-content-grid">
    <section class="admin-panel dashboard-panel">
        <div class="admin-panel-head">
            <div class="admin-section-heading">
                <div class="admin-section-icon"><i class="bi bi-calendar-event"></i></div>
                <div>
                    <h2 class="admin-panel-title mb-1">Proximas citas</h2>
                    <div class="admin-mini">Agenda del dia</div>
                </div>
            </div>
            <a href="{{ route('fitapp.admin.citas') }}" class="admin-panel-link">Abrir agenda <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="admin-panel-body">
            <div class="dashboard-list">
                <div class="dashboard-list-item">
                    <div class="dashboard-list-icon"><i class="bi bi-person"></i></div>
                    <div class="dashboard-list-copy">
                        <strong>Maria Gonzalez</strong>
                        <span>Valoracion inicial &middot; 11:00 AM</span>
                    </div>
                    <span class="admin-tag blue">Mercado Pago</span>
                </div>

                <div class="dashboard-list-item">
                    <div class="dashboard-list-icon"><i class="bi bi-person"></i></div>
                    <div class="dashboard-list-copy">
                        <strong>Jorge Ramirez</strong>
                        <span>Valoracion inicial &middot; 12:30 PM</span>
                    </div>
                    <span class="admin-tag yellow">Efectivo</span>
                </div>

                <div class="dashboard-list-item">
                    <div class="dashboard-list-icon"><i class="bi bi-egg-fried"></i></div>
                    <div class="dashboard-list-copy">
                        <strong>Karla Hernandez</strong>
                        <span>Seguimiento nutricional &middot; 04:00 PM</span>
                    </div>
                    <span class="admin-tag red">Pendiente</span>
                </div>

                <div class="dashboard-list-item">
                    <div class="dashboard-list-icon"><i class="bi bi-activity"></i></div>
                    <div class="dashboard-list-copy">
                        <strong>Daniel Torres</strong>
                        <span>Revision tecnica &middot; 06:00 PM</span>
                    </div>
                    <span class="admin-tag blue">Confirmada</span>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-panel dashboard-panel">
        <div class="admin-panel-head">
            <div class="admin-section-heading">
                <div class="admin-section-icon warn"><i class="bi bi-lightning-charge"></i></div>
                <div>
                    <h2 class="admin-panel-title mb-1">Pendientes rapidos</h2>
                    <div class="admin-mini">Hoy</div>
                </div>
            </div>
        </div>

        <div class="admin-panel-body">
            <div class="dashboard-task-list">
                <a href="{{ route('fitapp.admin.evidencias') }}" class="dashboard-task-item">
                    <i class="bi bi-camera-video"></i>
                    <span><strong>7 videos por revisar</strong><small>Ejercicios con evidencia marcada.</small></span>
                </a>

                <a href="{{ route('fitapp.admin.nutricion') }}" class="dashboard-task-item">
                    <i class="bi bi-image"></i>
                    <span><strong>10 fotos de comida pendientes</strong><small>Usuarios con plan nutricional activo.</small></span>
                </a>

                <a href="{{ route('fitapp.admin.planes') }}" class="dashboard-task-item">
                    <i class="bi bi-clipboard2-check"></i>
                    <span><strong>4 planes por cerrar</strong><small>Usuarios con valoracion presencial.</small></span>
                </a>

                <a href="{{ route('fitapp.admin.pagos') }}" class="dashboard-task-item">
                    <i class="bi bi-cash-coin"></i>
                    <span><strong>3 reservas en efectivo</strong><small>Validar asistencia en consultorio.</small></span>
                </a>
            </div>
        </div>
    </section>
</div>

<section class="admin-panel dashboard-panel mt-3">
    <div class="admin-panel-head">
        <div class="admin-section-heading">
            <div class="admin-section-icon success"><i class="bi bi-clock-history"></i></div>
            <div>
                <h2 class="admin-panel-title mb-1">Actividad reciente</h2>
                <div class="admin-mini">Ultimos movimientos</div>
            </div>
        </div>
    </div>

    <div class="admin-panel-body">
        <div class="admin-table-wrap dashboard-table-wrap">
            <table class="admin-table dashboard-table">
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
                        <td data-label="Usuario">Maria Gonzalez</td>
                        <td data-label="Evento">Reservo cita inicial</td>
                        <td data-label="Hora">09:14 AM</td>
                        <td data-label="Estatus"><span class="admin-tag blue">Confirmada</span></td>
                    </tr>
                    <tr>
                        <td data-label="Usuario">Alan Perez</td>
                        <td data-label="Evento">Subio evidencia de Sentadilla Goblet</td>
                        <td data-label="Hora">09:40 AM</td>
                        <td data-label="Estatus"><span class="admin-tag yellow">Pendiente revision</span></td>
                    </tr>
                    <tr>
                        <td data-label="Usuario">Fernanda Ruiz</td>
                        <td data-label="Evento">Mando foto de comida</td>
                        <td data-label="Hora">10:05 AM</td>
                        <td data-label="Estatus"><span class="admin-tag yellow">Pendiente</span></td>
                    </tr>
                    <tr>
                        <td data-label="Usuario">Jorge Ramirez</td>
                        <td data-label="Evento">Selecciono pago en efectivo</td>
                        <td data-label="Hora">10:21 AM</td>
                        <td data-label="Estatus"><span class="admin-tag red">Validar asistencia</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
