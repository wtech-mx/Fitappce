@extends('layouts.fitapp')

@section('title', 'Reserva confirmada | FitApp')

@section('content')
<div class="section-pad d-flex flex-column min-vh-100">
    <div class="app-bar">
        <a href="{{ route('fitapp.onboarding.appointment') }}" class="app-bar-btn text-dark">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span class="step-badge">Resumen</span>
    </div>

    <div class="purchase-check-card mb-4">
        <div class="purchase-check-icon">
            <i class="bi bi-check2-circle"></i>
        </div>
        <div class="page-kicker text-dark mb-2">
            <i class="bi bi-calendar-check"></i> Cita reservada
        </div>
        <h1 class="fit-title text-dark mb-2">Tu valoración quedó apartada</h1>
        <p class="text-dark-50 mb-0">
            Revisaremos tu información y te enviaremos la confirmación final de la cita.
        </p>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
            <div class="fw-bold">Resumen de compra</div>
            <span class="status-pill" style="background:var(--fa-success-bg); color:var(--fa-success-text);">
                Reservado
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Servicio</span>
            <span class="summary-value">Rutina + nutrición</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Tipo de plan</span>
            <span class="summary-value">Personalizado</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Objetivo</span>
            <span class="summary-value">Masa muscular</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Fecha y hora</span>
            <span class="summary-value">
                <span id="summaryDate">9 abril</span>, <span id="summaryTime">11:00 AM</span>
            </span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Modalidad</span>
            <span class="summary-value" id="summaryMode">Presencial</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Canal</span>
            <span class="summary-value" id="summaryChannel">Consultorio</span>
        </div>

        <div class="summary-row">
            <span class="summary-label">Forma de pago</span>
            <span class="summary-value" id="summaryPayment">Mercado Pago</span>
        </div>
    </div>

    <div class="purchase-total-box mb-4">
        <div class="d-flex justify-content-between align-items-center gap-3">
            <div>
                <div class="small text-white-50 mb-1">Apartado de reserva</div>
                <div class="fw-bold">Total pagado / por confirmar</div>
            </div>
            <div class="fw-bold fs-4">$<span id="summaryAmount">100</span> MXN</div>
        </div>
    </div>

    <div class="surface-card p-4 mb-4">
        <div class="fw-bold mb-3">Siguiente paso</div>

        <div class="next-step-item mb-3">
            <i class="bi bi-chat-dots-fill"></i>
            <div>
                <div class="fw-bold">Confirmación del coach</div>
                <div class="fit-subtitle" id="nextStepCopy">
                    Te enviaremos la dirección del consultorio y las indicaciones para llegar.
                </div>
            </div>
        </div>

        <div class="next-step-item">
            <i class="bi bi-clipboard2-pulse-fill"></i>
            <div>
                <div class="fw-bold">Preparación de tu plan</div>
                <div class="fit-subtitle">
                    Con tu perfil inicial se prepara la rutina, nutrición y seguimiento dentro de la app.
                </div>
            </div>
        </div>
    </div>

    <div class="mt-auto d-grid gap-3">
        <a href="{{ route('fitapp.dashboard') }}" class="btn btn-accent-custom w-100">
            Ir a mi dashboard
        </a>
        <a href="{{ route('fitapp.onboarding.appointment') }}" class="btn btn-soft-custom w-100">
            Ajustar cita
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        const mode = params.get('modalidad') || 'presencial';
        const channel = params.get('canal') || 'consultorio';
        const payment = params.get('pago') || 'mercado-pago';

        const labels = {
            mode: {
                presencial: 'Presencial',
                online: 'Online',
            },
            channel: {
                consultorio: 'Consultorio',
                whatsapp: 'Llamada por WhatsApp',
                'google-meet': 'Google Meet',
            },
            payment: {
                'mercado-pago': 'Mercado Pago',
                efectivo: 'Efectivo en cita',
            },
        };

        document.getElementById('summaryDate').textContent = params.get('fecha') || '9 abril';
        document.getElementById('summaryTime').textContent = params.get('hora') || '11:00 AM';
        document.getElementById('summaryAmount').textContent = params.get('monto') || '100';
        document.getElementById('summaryMode').textContent = labels.mode[mode] || 'Presencial';
        document.getElementById('summaryChannel').textContent = labels.channel[channel] || 'Consultorio';
        document.getElementById('summaryPayment').textContent = labels.payment[payment] || 'Mercado Pago';

        if (mode === 'online') {
            document.getElementById('nextStepCopy').textContent = 'Te enviaremos los datos de conexión para tu llamada por WhatsApp o Google Meet.';
        }
    });
</script>
@endpush
