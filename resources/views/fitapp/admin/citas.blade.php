@extends('layouts.fitapp-admin')

@section('title', 'Citas | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Agenda de citas</h1>
        <div class="admin-topbar-subtitle">Vista mensual y semanal con reservas, seguimientos y bloqueos de horario.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4" data-bs-toggle="modal" data-bs-target="#slotModal">
            Nuevo bloqueo
        </button>
        <button class="admin-icon-btn" type="button">
            <i class="bi bi-calendar-plus"></i>
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active"><i class="bi bi-circle-fill"></i> Todas</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-primary"></i> Valoración</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-warning"></i> Seguimiento</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-danger"></i> Bloqueados</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar usuario o cita...">
    </div>
</div>

<div class="admin-split-grid">
    <div class="fc-wrap">
        <div id="adminCalendar"></div>
    </div>

    <div class="admin-side-stack">
        <section class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Resumen del día</h2>
                <span class="small text-muted">Martes 09</span>
            </div>

            <div class="admin-panel-body">
                <div class="admin-inline-stats mb-3">
                    <div class="admin-inline-stat">
                        <div class="value">5</div>
                        <div class="label">Citas</div>
                    </div>
                    <div class="admin-inline-stat">
                        <div class="value">2</div>
                        <div class="label">Pendientes</div>
                    </div>
                    <div class="admin-inline-stat">
                        <div class="value">1</div>
                        <div class="label">Bloqueo</div>
                    </div>
                </div>

                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">11:00 AM · María González</div>
                                <div class="admin-mini">Valoración inicial · Mercado Pago</div>
                            </div>
                            <span class="admin-tag blue">Confirmada</span>
                        </div>
                    </div>

                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">12:30 PM · Jorge Ramírez</div>
                                <div class="admin-mini">Valoración inicial · Efectivo</div>
                            </div>
                            <span class="admin-tag yellow">Pendiente llegada</span>
                        </div>
                    </div>

                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">04:00 PM · Bloqueado</div>
                                <div class="admin-mini">Horario no disponible</div>
                            </div>
                            <span class="admin-tag red">Cerrado</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Notas rápidas</h2>
                <span class="small text-muted">Operación</span>
            </div>

            <div class="admin-panel-body">
                <ul class="info-list mb-0">
                    <li>Click en una cita para abrir detalle</li>
                    <li>Click en un día libre para crear disponibilidad</li>
                    <li>Luego se puede conectar a backend con feed JSON</li>
                    <li>Mercado Pago y efectivo seguirán entrando como tipos de reserva</li>
                </ul>
            </div>
        </section>
    </div>
</div>

{{-- MODAL DETALLE CITA --}}
<div class="modal fade modal-fitapp" id="appointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1" id="appointmentModalTitle">Detalle de cita</h5>
                    <div class="small text-muted" id="appointmentModalSub">Sin datos</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="surface-card p-3 mb-3">
                    <div class="fw-bold mb-2">Información</div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Usuario</span>
                        <span class="fw-bold" id="appointmentUser">—</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tipo</span>
                        <span class="fw-bold" id="appointmentType">—</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Pago</span>
                        <span class="fw-bold" id="appointmentPayment">—</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Estatus</span>
                        <span class="fw-bold" id="appointmentStatus">—</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary-custom">Ver expediente</button>
                    <button class="btn btn-soft-custom">Reagendar</button>
                    <button class="btn btn-outline-danger rounded-4">Cancelar cita</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL BLOQUEO --}}
<div class="modal fade modal-fitapp" id="slotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Bloquear horario</h5>
                    <div class="small text-muted">Demo visual sin lógica todavía</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" class="form-control input-soft">
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Hora inicio</label>
                        <input type="time" class="form-control input-soft">
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Hora fin</label>
                        <input type="time" class="form-control input-soft">
                    </div>
                </div>

                <div class="mt-3 mb-4">
                    <label class="form-label fw-bold">Motivo</label>
                    <input type="text" class="form-control input-soft" placeholder="Descanso, consulta externa, etc.">
                </div>

                <button class="btn btn-primary-custom w-100">Guardar bloqueo</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- FullCalendar script-tag global bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.20/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.20/locales-all.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('adminCalendar');
            const modalEl = document.getElementById('appointmentModal');
            const appointmentModal = new bootstrap.Modal(modalEl);

            const demoEvents = [
                {
                    title: 'María González',
                    start: '2026-04-09T11:00:00',
                    end: '2026-04-09T11:45:00',
                    color: '#2E86AB',
                    extendedProps: {
                        type: 'Valoración inicial',
                        payment: 'Mercado Pago',
                        status: 'Confirmada'
                    }
                },
                {
                    title: 'Jorge Ramírez',
                    start: '2026-04-09T12:30:00',
                    end: '2026-04-09T13:15:00',
                    color: '#F5A623',
                    extendedProps: {
                        type: 'Valoración inicial',
                        payment: 'Efectivo',
                        status: 'Pendiente llegada'
                    }
                },
                {
                    title: 'Bloqueado',
                    start: '2026-04-09T16:00:00',
                    end: '2026-04-09T17:00:00',
                    color: '#F24236',
                    extendedProps: {
                        type: 'Horario bloqueado',
                        payment: 'N/A',
                        status: 'Cerrado'
                    }
                },
                {
                    title: 'Karla Hernández',
                    start: '2026-04-10T10:00:00',
                    end: '2026-04-10T10:45:00',
                    color: '#2E86AB',
                    extendedProps: {
                        type: 'Seguimiento nutricional',
                        payment: 'Mercado Pago',
                        status: 'Confirmada'
                    }
                }
            ];

            const calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap5',
                locale: 'es',
                initialView: 'timeGridWeek',
                height: 'auto',
                nowIndicator: true,
                selectable: true,
                editable: false,
                dayMaxEvents: true,
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: demoEvents,

                dateClick: function(info) {
                    document.getElementById('appointmentModalTitle').textContent = 'Nuevo horario';
                    document.getElementById('appointmentModalSub').textContent = info.dateStr;
                    document.getElementById('appointmentUser').textContent = 'Disponible';
                    document.getElementById('appointmentType').textContent = 'Crear disponibilidad o bloqueo';
                    document.getElementById('appointmentPayment').textContent = '—';
                    document.getElementById('appointmentStatus').textContent = 'Libre';
                    appointmentModal.show();
                },

                eventClick: function(info) {
                    const event = info.event;

                    document.getElementById('appointmentModalTitle').textContent = event.title;
                    document.getElementById('appointmentModalSub').textContent =
                        event.start ? event.start.toLocaleString('es-MX') : 'Sin fecha';

                    document.getElementById('appointmentUser').textContent = event.title;
                    document.getElementById('appointmentType').textContent = event.extendedProps.type || '—';
                    document.getElementById('appointmentPayment').textContent = event.extendedProps.payment || '—';
                    document.getElementById('appointmentStatus').textContent = event.extendedProps.status || '—';

                    appointmentModal.show();
                }
            });

            calendar.render();
        });
    </script>
@endpush
