@extends('layouts.fitapp-admin')

@section('title', 'Citas | FitCoach Admin')

@php
    $calendarEvents = $appointments->map(fn ($appointment) => [
        'title' => $appointment->kind === 'block' ? $appointment->title : ($appointment->user?->name ?: $appointment->title),
        'start' => $appointment->starts_at->toIso8601String(),
        'end' => $appointment->ends_at->toIso8601String(),
        'color' => $appointment->kind === 'block' ? '#F24236' : ($appointment->status === 'confirmed' ? '#2E86AB' : '#F5A623'),
        'extendedProps' => [
            'id' => $appointment->id,
            'kind' => $appointment->kind,
            'user' => $appointment->user?->name ?: 'Sin cliente',
            'userUrl' => $appointment->user ? route('fitapp.admin.usuarios.expediente', $appointment->user) : null,
            'updateUrl' => $appointment->kind === 'appointment' ? route('fitapp.admin.citas.update', $appointment) : null,
            'type' => $appointment->appointment_type ?: 'Horario bloqueado',
            'date' => $appointment->starts_at->toDateString(),
            'time' => $appointment->starts_at->format('H:i'),
            'duration' => $appointment->duration_minutes,
            'payment' => $appointment->payment_method ?: 'Pendiente',
            'paymentValue' => $appointment->payment_method ?: '',
            'status' => $appointment->statusLabel(),
            'statusValue' => $appointment->status,
            'modality' => $appointment->modality,
            'notes' => $appointment->notes ?: 'Sin notas',
            'notesValue' => $appointment->notes ?: '',
        ],
    ])->values();

    $todayBlocks = $todayAppointments->where('kind', 'block')->count();
    $todayClientAppointments = $todayAppointments->where('kind', 'appointment')->count();
@endphp

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Agenda de citas</h1>
        <div class="admin-topbar-subtitle">Citas reales, seguimientos y horarios bloqueados.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-soft-custom px-4" data-bs-toggle="modal" data-bs-target="#appointmentCreateModal">
            <i class="bi bi-calendar-plus me-1"></i> Nueva cita
        </button>
        <button class="btn btn-primary-custom px-4" data-bs-toggle="modal" data-bs-target="#slotModal">
            Nuevo bloqueo
        </button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<div class="admin-filter-bar">
    <span class="admin-filter-chip active"><i class="bi bi-circle-fill"></i> Todas</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-primary"></i> Confirmadas</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-warning"></i> Pendientes</span>
    <span class="admin-filter-chip"><i class="bi bi-circle-fill text-danger"></i> Bloqueados</span>
</div>

<div class="admin-split-grid">
    <div class="fc-wrap">
        <div id="adminCalendar"></div>
    </div>

    <div class="admin-side-stack">
        <section class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Resumen de hoy</h2>
                <span class="small text-muted">{{ now()->format('d/m/Y') }}</span>
            </div>

            <div class="admin-panel-body">
                <div class="admin-inline-stats mb-3">
                    <div class="admin-inline-stat">
                        <div class="value">{{ $todayClientAppointments }}</div>
                        <div class="label">Citas</div>
                    </div>
                    <div class="admin-inline-stat">
                        <div class="value">{{ $todayAppointments->where('status', 'scheduled')->count() }}</div>
                        <div class="label">Pendientes</div>
                    </div>
                    <div class="admin-inline-stat">
                        <div class="value">{{ $todayBlocks }}</div>
                        <div class="label">Bloqueos</div>
                    </div>
                </div>

                <div class="admin-list">
                    @forelse ($todayAppointments as $appointment)
                        <div class="admin-list-item">
                            <div class="admin-list-row">
                                <div>
                                    <div class="fw-bold">{{ $appointment->starts_at->format('h:i A') }} · {{ $appointment->kind === 'block' ? $appointment->title : $appointment->user?->name }}</div>
                                    <div class="admin-mini">{{ $appointment->appointment_type ?: 'Horario bloqueado' }} · {{ $appointment->payment_method ?: $appointment->modality }}</div>
                                </div>
                                <span class="admin-tag {{ $appointment->statusClass() }}">{{ $appointment->statusLabel() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="admin-helper-note">
                            <div class="fw-bold mb-1">Dia libre</div>
                            <div class="admin-mini">No hay citas ni bloqueos registrados para hoy.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title">Proximas citas</h2>
                <span class="small text-muted">{{ $appointments->where('kind', 'appointment')->count() }} activas</span>
            </div>
            <div class="admin-panel-body">
                <div class="admin-list">
                    @forelse ($appointments->where('kind', 'appointment')->take(5) as $appointment)
                        <div class="admin-list-item">
                            <div class="admin-list-row">
                                <div>
                                    <div class="fw-bold">{{ $appointment->starts_at->format('d/m · h:i A') }}</div>
                                    <div class="admin-mini">{{ $appointment->user?->name }} · {{ $appointment->appointment_type }}</div>
                                </div>
                                @if($appointment->user)
                                    <a href="{{ route('fitapp.admin.usuarios.expediente', $appointment->user) }}" class="admin-btn-soft">Expediente</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="admin-helper-note">Aun no hay citas registradas.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>

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
                    <div class="fw-bold mb-2">Informacion</div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Usuario</span><span class="fw-bold" id="appointmentUser">-</span></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Tipo</span><span class="fw-bold" id="appointmentType">-</span></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Pago</span><span class="fw-bold" id="appointmentPayment">-</span></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Modalidad</span><span class="fw-bold" id="appointmentModality">-</span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Estatus</span><span class="fw-bold" id="appointmentStatus">-</span></div>
                </div>
                <div class="admin-text-block mb-3" id="appointmentNotes">Sin notas</div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-soft-custom" id="appointmentRescheduleButton" data-bs-toggle="modal" data-bs-target="#appointmentRescheduleModal">
                        <i class="bi bi-calendar2-week me-1"></i> Reagendar
                    </button>
                    <a href="#" class="btn btn-primary-custom w-100" id="appointmentRecordLink">Ver expediente</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-fitapp" id="appointmentRescheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="#" class="modal-content" id="appointmentRescheduleForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="redirect_to" value="{{ route('fitapp.admin.citas') }}">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Reagendar cita</h5>
                    <div class="small text-muted" id="appointmentRescheduleUser">Selecciona nueva fecha y hora.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipo</label>
                    <select name="appointment_type" class="form-select input-soft" data-reschedule-type>
                        <option>Seguimiento mensual</option>
                        <option>Valoracion inicial</option>
                        <option>Renovacion de plan</option>
                        <option>Revision tecnica</option>
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-7">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="appointment_date" class="form-control input-soft" data-reschedule-date required>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">Hora</label>
                        <input type="time" name="appointment_time" class="form-control input-soft" data-reschedule-time required>
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-6">
                        <label class="form-label fw-bold">Duracion</label>
                        <select name="duration_minutes" class="form-select input-soft" data-reschedule-duration>
                            <option value="30">30 min</option>
                            <option value="45">45 min</option>
                            <option value="60">60 min</option>
                            <option value="90">90 min</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Modalidad</label>
                        <select name="modality" class="form-select input-soft" data-reschedule-modality><option>Presencial</option><option>Online</option></select>
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-6">
                        <label class="form-label fw-bold">Pago</label>
                        <select name="payment_method" class="form-select input-soft" data-reschedule-payment><option value="">Pendiente</option><option>Efectivo</option><option>Mercado Pago</option><option>Transferencia</option></select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Estatus</label>
                        <select name="status" class="form-select input-soft" data-reschedule-status><option value="scheduled">Agendada</option><option value="confirmed">Confirmada</option><option value="in_progress">En curso</option><option value="completed">Completada</option><option value="cancelled">Cancelada</option></select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label fw-bold">Notas</label>
                    <textarea name="notes" class="form-control input-soft" rows="3" data-reschedule-notes></textarea>
                </div>
                <button class="btn btn-primary-custom w-100 mt-4">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-fitapp" id="appointmentCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('fitapp.admin.citas.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Nueva cita</h5>
                    <div class="small text-muted">Se validan empalmes contra citas y bloqueos.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Cliente</label>
                    <select name="user_id" class="form-select input-soft" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-3">
                    <div class="col-7">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="appointment_date" class="form-control input-soft" value="{{ now()->addDay()->toDateString() }}" required>
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-bold">Hora</label>
                        <input type="time" name="appointment_time" class="form-control input-soft" value="10:00" required>
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-6">
                        <label class="form-label fw-bold">Tipo</label>
                        <select name="appointment_type" class="form-select input-soft">
                            <option>Seguimiento mensual</option>
                            <option>Valoracion inicial</option>
                            <option>Renovacion de plan</option>
                            <option>Revision tecnica</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Duracion</label>
                        <select name="duration_minutes" class="form-select input-soft">
                            <option value="30">30 min</option>
                            <option value="45" selected>45 min</option>
                            <option value="60">60 min</option>
                            <option value="90">90 min</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-6">
                        <label class="form-label fw-bold">Modalidad</label>
                        <select name="modality" class="form-select input-soft"><option>Presencial</option><option>Online</option></select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Estatus</label>
                        <select name="status" class="form-select input-soft"><option value="scheduled">Agendada</option><option value="confirmed">Confirmada</option><option value="in_progress">En curso</option></select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label fw-bold">Pago</label>
                    <select name="payment_method" class="form-select input-soft"><option value="">Pendiente</option><option>Efectivo</option><option>Mercado Pago</option><option>Transferencia</option></select>
                </div>
                <button class="btn btn-primary-custom w-100 mt-4">Guardar cita</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-fitapp" id="slotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('fitapp.admin.citas.bloqueos.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Bloquear horario</h5>
                    <div class="small text-muted">Cierra espacios donde el coach no puede atender.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" name="appointment_date" class="form-control input-soft" value="{{ now()->toDateString() }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-bold">Hora inicio</label>
                        <input type="time" name="starts_at" class="form-control input-soft" value="16:00" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Hora fin</label>
                        <input type="time" name="ends_at" class="form-control input-soft" value="17:00" required>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label fw-bold">Motivo</label>
                    <input type="text" name="title" class="form-control input-soft" placeholder="Consulta externa, descanso, pendiente personal..." required>
                </div>
                <button class="btn btn-primary-custom w-100 mt-4">Guardar bloqueo</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.20/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.20/locales-all.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('adminCalendar');
            const modalEl = document.getElementById('appointmentModal');
            const appointmentModal = new bootstrap.Modal(modalEl);
            const rescheduleForm = document.getElementById('appointmentRescheduleForm');
            const rescheduleButton = document.getElementById('appointmentRescheduleButton');
            const events = @json($calendarEvents);

            const setField = (selector, value) => {
                const field = document.querySelector(selector);
                if (field) field.value = value || '';
            };

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
                buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Dia', list: 'Lista' },
                events,
                eventClick: function(info) {
                    const event = info.event;
                    const props = event.extendedProps;

                    document.getElementById('appointmentModalTitle').textContent = event.title;
                    document.getElementById('appointmentModalSub').textContent = event.start ? event.start.toLocaleString('es-MX') : 'Sin fecha';
                    document.getElementById('appointmentUser').textContent = props.user || 'Sin cliente';
                    document.getElementById('appointmentType').textContent = props.type || '-';
                    document.getElementById('appointmentPayment').textContent = props.payment || '-';
                    document.getElementById('appointmentModality').textContent = props.modality || '-';
                    document.getElementById('appointmentStatus').textContent = props.status || '-';
                    document.getElementById('appointmentNotes').textContent = props.notes || 'Sin notas';

                    const link = document.getElementById('appointmentRecordLink');
                    link.href = props.userUrl || '#';
                    link.classList.toggle('disabled', !props.userUrl);
                    rescheduleButton.classList.toggle('d-none', !props.updateUrl);

                    if (props.updateUrl && rescheduleForm) {
                        rescheduleForm.action = props.updateUrl;
                        document.getElementById('appointmentRescheduleUser').textContent = props.user || 'Sin cliente';
                        setField('[data-reschedule-type]', props.type);
                        setField('[data-reschedule-date]', props.date);
                        setField('[data-reschedule-time]', props.time);
                        setField('[data-reschedule-duration]', props.duration);
                        setField('[data-reschedule-modality]', props.modality);
                        setField('[data-reschedule-payment]', props.paymentValue);
                        setField('[data-reschedule-status]', props.statusValue);
                        setField('[data-reschedule-notes]', props.notesValue);
                    }
                    appointmentModal.show();
                }
            });

            calendar.render();
        });
    </script>
@endpush
