@extends('layouts.fitapp')

@section('title', 'Agendar cita | FitApp')

@section('content')
<div class="section-pad">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.nutrition') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Paso 5 de 5</span>
    </div>

    <div class="progress-slim mb-4">
        <div class="bar" style="width:100%;"></div>
    </div>

    <div class="mb-4">
        <div class="page-kicker">
            <i class="bi bi-calendar-check"></i> Cita inicial
        </div>
        <h1 class="fit-title mb-2">Agenda tu valoración</h1>
        <p class="fit-subtitle mb-0">
            Elige fecha, horario y forma de pago para asistir al consultorio y continuar con tu proceso personalizado.
        </p>
    </div>

    <div class="payment-price-box mb-4">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <div class="page-kicker text-white mb-1">
                    <i class="bi bi-shield-check"></i> Reserva de asistencia
                </div>
                <div class="fw-bold fs-5 mb-1">$100 MXN</div>
                <div class="small text-white-50">
                    Este monto funciona como apartado simbólico para asegurar tu asistencia a la cita.
                </div>
            </div>
            <span class="status-pill" style="background:rgba(245,247,73,.18); color:#F5F749;">
                Reserva
            </span>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Resumen rápido de tu perfil</div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Objetivo</span>
            <span class="fw-bold">Masa muscular</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Servicio</span>
            <span class="fw-bold">Rutina + nutrición</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Plan</span>
            <span class="fw-bold">Personalizado</span>
        </div>

        <div class="d-flex justify-content-between">
            <span class="text-muted">Entrena en</span>
            <span class="fw-bold">Gimnasio</span>
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Selecciona una fecha</h2>
        <span class="mini-note">Disponibles</span>
    </div>

    <div class="calendar-mini mb-4">
        <button type="button" class="calendar-day-btn">
            <div class="calendar-day-top">Lun</div>
            <div class="calendar-day-number">08</div>
            <div class="calendar-day-month">Abr</div>
        </button>

        <button type="button" class="calendar-day-btn active">
            <div class="calendar-day-top">Mar</div>
            <div class="calendar-day-number">09</div>
            <div class="calendar-day-month">Abr</div>
        </button>

        <button type="button" class="calendar-day-btn">
            <div class="calendar-day-top">Mié</div>
            <div class="calendar-day-number">10</div>
            <div class="calendar-day-month">Abr</div>
        </button>

        <button type="button" class="calendar-day-btn">
            <div class="calendar-day-top">Jue</div>
            <div class="calendar-day-number">11</div>
            <div class="calendar-day-month">Abr</div>
        </button>

        <button type="button" class="calendar-day-btn">
            <div class="calendar-day-top">Vie</div>
            <div class="calendar-day-number">12</div>
            <div class="calendar-day-month">Abr</div>
        </button>

        <button type="button" class="calendar-day-btn">
            <div class="calendar-day-top">Sáb</div>
            <div class="calendar-day-number">13</div>
            <div class="calendar-day-month">Abr</div>
        </button>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Selecciona un horario</h2>
        <span class="mini-note">9 abril</span>
    </div>

    <div class="time-slot-grid mb-4">
        <button type="button" class="time-slot-btn">10:00 AM</button>
        <button type="button" class="time-slot-btn active">11:00 AM</button>
        <button type="button" class="time-slot-btn">12:30 PM</button>
        <button type="button" class="time-slot-btn">04:00 PM</button>
        <button type="button" class="time-slot-btn">05:30 PM</button>
        <button type="button" class="time-slot-btn">06:30 PM</button>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Forma de pago</h2>
        <span class="mini-note">$100 para reservar</span>
    </div>

    <div class="d-grid gap-3 mb-4">
        <div class="payment-option-card active">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3">
                    <div class="option-icon mb-0">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Mercado Pago</div>
                        <div class="fit-subtitle">
                            Paga en línea el apartado simbólico para asegurar tu asistencia.
                        </div>
                    </div>
                </div>
                <i class="bi bi-check-circle-fill text-primary-custom"></i>
            </div>
        </div>

        <div class="payment-option-card">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3">
                    <div class="option-icon mb-0">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Pagar en efectivo en la cita</div>
                        <div class="fit-subtitle">
                            El usuario aparta la cita y liquida el monto simbólico al llegar al consultorio.
                        </div>
                    </div>
                </div>
                <i class="bi bi-circle text-muted"></i>
            </div>
        </div>
    </div>

    <div class="policy-note mb-4">
        <div class="policy-note-title">Política de asistencia</div>
        <div class="policy-note-text">
            El apartado de <strong>$100 MXN</strong> es para asegurar la asistencia. Si la persona no se presenta a la cita, ese monto se retiene y no se toma a cuenta.
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Ubicación del consultorio</h2>
        <span class="mini-note">Mapa</span>
    </div>

    <div class="surface-card p-3 mb-3">
        <div class="fw-bold mb-1">Consultorio / valoración inicial</div>
        <div class="fit-subtitle">
            Aquí irá la dirección exacta del consultorio y las referencias para llegar.
        </div>
    </div>

    <div class="map-placeholder mb-4">
        <div>
            <i class="bi bi-geo-alt-fill"></i>
            <div class="fw-bold mb-1">Aquí irá el mapa del consultorio</div>
            <div class="small text-muted">
                Cuando me pases la dirección exacta, te dejo el bloque con mapa embebido o diseño visual listo.
            </div>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-2">Lo que sigue después de reservar</div>
        <ul class="info-list mb-0">
            <li>Confirmación de fecha y hora</li>
            <li>Asistencia al consultorio</li>
            <li>Valoración presencial</li>
            <li>Inicio del proceso personalizado</li>
        </ul>
    </div>

    <a href="{{ route('fitapp.dashboard') }}" class="btn btn-accent-custom w-100">
        Confirmar cita y continuar
    </a>
</div>
@endsection
