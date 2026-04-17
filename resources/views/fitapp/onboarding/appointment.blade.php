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
        <h2 class="h6 fw-bold mb-0">Modalidad de cita</h2>
        <span class="mini-note">Presencial u online</span>
    </div>

    <div class="d-grid gap-3 mb-4">
        <button type="button" class="appointment-choice-card active" data-appointment-mode="presencial" style="border: solid 1px transparent;">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3 text-start">
                    <div class="option-icon mb-0">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Presencial en consultorio</div>
                        <div class="fit-subtitle">
                            Asiste al consultorio para tu valoración inicial y mediciones.
                        </div>
                    </div>
                </div>
                <i class="bi bi-check-circle-fill text-primary-custom choice-check"></i>
            </div>
        </button>

        <button type="button" class="appointment-choice-card" data-appointment-mode="online" style="border: solid 1px transparent;">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3 text-start">
                    <div class="option-icon mb-0">
                        <i class="bi bi-camera-video"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Online</div>
                        <div class="fit-subtitle">
                            Agenda una llamada por WhatsApp o Google Meet para iniciar a distancia.
                        </div>
                    </div>
                </div>
                <i class="bi bi-circle text-muted choice-check"></i>
            </div>
        </button>
    </div>

    <div class="mb-4 d-none" id="onlineChannelPanel">
        <div class="section-title-row">
            <h2 class="h6 fw-bold mb-0">Canal de llamada</h2>
            <span class="mini-note">Solo online</span>
        </div>

        <div class="time-slot-grid">
            <button type="button" class="time-slot-btn active" data-online-channel="whatsapp">
                <i class="bi bi-whatsapp me-1"></i> WhatsApp
            </button>
            <button type="button" class="time-slot-btn" data-online-channel="google-meet">
                <i class="bi bi-camera-video me-1"></i> Google Meet
            </button>
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Forma de pago</h2>
        <span class="mini-note">$100 para reservar</span>
    </div>

    <div class="d-grid gap-3 mb-4">
        <button type="button" class="payment-option-card active" data-payment-method="mercado-pago" >
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3 text-start">
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
                <i class="bi bi-check-circle-fill text-primary-custom payment-check"></i>
            </div>
        </button>

        <button type="button" class="payment-option-card" data-payment-method="efectivo" >
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div class="d-flex gap-3 text-start">
                    <div class="option-icon mb-0">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Pagar en efectivo en la cita</div>
                        <div class="fit-subtitle" data-cash-copy>
                            El usuario aparta la cita y liquida el monto simbólico al llegar al consultorio.
                        </div>
                    </div>
                </div>
                <i class="bi bi-circle text-muted payment-check"></i>
            </div>
        </button>
    </div>

    <div class="policy-note mb-4">
        <div class="policy-note-title">Política de asistencia</div>
        <div class="policy-note-text" id="paymentPolicyText">
            El apartado de <strong>$100 MXN</strong> es para asegurar la asistencia. Si la persona no se presenta a la cita, ese monto se retiene y no se toma a cuenta.
        </div>
    </div>

    <div class="section-title-row">
        <h2 class="h6 fw-bold mb-0">Ubicación del consultorio</h2>
        <span class="mini-note">Mapa</span>
    </div>

    <div class="surface-card p-3 mb-3">
        <div class="fw-bold mb-1" id="locationInfoTitle">Consultorio / valoración inicial</div>
        <div class="fit-subtitle" id="locationInfoText">
            Aquí irá la dirección exacta del consultorio y las referencias para llegar.
        </div>
    </div>

    <div class="map-placeholder mb-4">
        <div>
            <i class="bi bi-geo-alt-fill" id="locationVisualIcon"></i>
            <div class="fw-bold mb-1" id="locationVisualTitle">Aquí irá el mapa del consultorio</div>
            <div class="small text-muted" id="locationVisualText">
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

    <a href="{{ route('fitapp.onboarding.thankyou') }}" class="btn btn-accent-custom w-100" id="confirmAppointmentLink">
        Confirmar cita y continuar
    </a>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modeCards = document.querySelectorAll('[data-appointment-mode]');
        const paymentCards = document.querySelectorAll('[data-payment-method]');
        const channelButtons = document.querySelectorAll('[data-online-channel]');
        const channelPanel = document.getElementById('onlineChannelPanel');
        const cashCard = document.querySelector('[data-payment-method="efectivo"]');
        const mercadoPagoCard = document.querySelector('[data-payment-method="mercado-pago"]');
        const cashCopy = document.querySelector('[data-cash-copy]');
        const paymentPolicyText = document.getElementById('paymentPolicyText');
        const locationInfoTitle = document.getElementById('locationInfoTitle');
        const locationInfoText = document.getElementById('locationInfoText');
        const locationVisualIcon = document.getElementById('locationVisualIcon');
        const locationVisualTitle = document.getElementById('locationVisualTitle');
        const locationVisualText = document.getElementById('locationVisualText');
        const confirmAppointmentLink = document.getElementById('confirmAppointmentLink');
        let selectedMode = 'presencial';
        let selectedChannel = 'whatsapp';
        let selectedPayment = 'mercado-pago';

        const updateConfirmLink = () => {
            const url = new URL(confirmAppointmentLink.href);

            url.searchParams.set('modalidad', selectedMode);
            url.searchParams.set('canal', selectedMode === 'online' ? selectedChannel : 'consultorio');
            url.searchParams.set('pago', selectedPayment);
            url.searchParams.set('fecha', '9 abril');
            url.searchParams.set('hora', '11:00 AM');
            url.searchParams.set('monto', '100');

            confirmAppointmentLink.href = url.toString();
        };

        const updateCheck = (card, selector, active) => {
            const icon = card.querySelector(selector);

            if (!icon) {
                return;
            }

            icon.className = active
                ? 'bi bi-check-circle-fill text-primary-custom ' + selector.slice(1)
                : 'bi bi-circle text-muted ' + selector.slice(1);
        };

        const setActiveCard = (cards, selectedCard, selector) => {
            cards.forEach((card) => {
                const active = card === selectedCard;

                card.classList.toggle('active', active);
                updateCheck(card, selector, active);
            });
        };

        const selectPayment = (card) => {
            if (!card || card.disabled) {
                return;
            }

            setActiveCard(paymentCards, card, '.payment-check');
            selectedPayment = card.dataset.paymentMethod;
            updateConfirmLink();
        };

        const setMode = (mode) => {
            const selectedModeCard = document.querySelector(`[data-appointment-mode="${mode}"]`);
            const isOnline = mode === 'online';

            selectedMode = mode;
            setActiveCard(modeCards, selectedModeCard, '.choice-check');
            channelPanel.classList.toggle('d-none', !isOnline);
            cashCard.disabled = isOnline;
            cashCard.classList.toggle('is-disabled', isOnline);

            if (isOnline) {
                selectPayment(mercadoPagoCard);
                cashCopy.textContent = 'No disponible para citas online. La reserva se cubre únicamente por Mercado Pago.';
                paymentPolicyText.innerHTML = 'Para citas online, el apartado de <strong>$100 MXN</strong> solo se puede pagar por Mercado Pago. Al confirmar, se compartirá el enlace o número para la llamada.';
                locationInfoTitle.textContent = 'Cita online';
                locationInfoText.textContent = 'Recibirás los datos de conexión según el canal elegido: llamada por WhatsApp o enlace de Google Meet.';
                locationVisualIcon.className = 'bi bi-camera-video-fill';
                locationVisualTitle.textContent = 'Llamada online';
                locationVisualText.textContent = 'El consultorio no aplica para esta modalidad; la sesión se realiza a distancia en el horario reservado.';
                updateConfirmLink();
                return;
            }

            cashCopy.textContent = 'El usuario aparta la cita y liquida el monto simbólico al llegar al consultorio.';
            paymentPolicyText.innerHTML = 'El apartado de <strong>$100 MXN</strong> es para asegurar la asistencia. Si la persona no se presenta a la cita, ese monto se retiene y no se toma a cuenta.';
            locationInfoTitle.textContent = 'Consultorio / valoración inicial';
            locationInfoText.textContent = 'Aquí irá la dirección exacta del consultorio y las referencias para llegar.';
            locationVisualIcon.className = 'bi bi-geo-alt-fill';
            locationVisualTitle.textContent = 'Aquí irá el mapa del consultorio';
            locationVisualText.textContent = 'Cuando me pases la dirección exacta, te dejo el bloque con mapa embebido o diseño visual listo.';
            updateConfirmLink();
        };

        modeCards.forEach((card) => {
            card.addEventListener('click', () => setMode(card.dataset.appointmentMode));
        });

        paymentCards.forEach((card) => {
            card.addEventListener('click', () => selectPayment(card));
        });

        channelButtons.forEach((button) => {
            button.addEventListener('click', () => {
                channelButtons.forEach((channelButton) => channelButton.classList.remove('active'));
                button.classList.add('active');
                selectedChannel = button.dataset.onlineChannel;
                updateConfirmLink();
            });
        });
        updateConfirmLink();
    });
</script>
@endpush
