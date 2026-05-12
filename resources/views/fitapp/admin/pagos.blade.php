@extends('layouts.fitapp-admin')

@section('title', 'Pagos | FitCoach Admin')

@section('content')
@php
    $payments = [
        ['user' => 'María González', 'service' => 'Rutina + nutrición', 'amount' => '$1,200 MXN', 'method' => 'Mercado Pago', 'status' => 'Pagado', 'date' => '09 Abr 2026', 'note' => 'Mensualidad personalizada'],
        ['user' => 'Jorge Ramírez', 'service' => 'Reserva de cita', 'amount' => '$100 MXN', 'method' => 'Efectivo', 'status' => 'Por confirmar', 'date' => '09 Abr 2026', 'note' => 'Apartado simbólico en consultorio'],
        ['user' => 'Fernanda Ruiz', 'service' => 'Plan alimentario', 'amount' => '$850 MXN', 'method' => 'Transferencia', 'status' => 'Pendiente', 'date' => '10 Abr 2026', 'note' => 'Comprobante pendiente de revisar'],
        ['user' => 'Adrián López', 'service' => 'Renovación mensual', 'amount' => '$1,500 MXN', 'method' => 'Mercado Pago', 'status' => 'Pagado', 'date' => '11 Abr 2026', 'note' => 'Plan personalizado mes 2'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Pagos</h1>
        <div class="admin-topbar-subtitle">Control visual de reservas, mensualidades, comprobantes y pagos por confirmar.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4">Registrar pago</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Ingresos del mes</div>
        <div class="admin-stat-value">$24.8k</div>
        <div class="admin-stat-note">Pagos confirmados</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Por revisar</div>
        <div class="admin-stat-value">11</div>
        <div class="admin-stat-note">Comprobantes y efectivo</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Reservas</div>
        <div class="admin-stat-value">$700</div>
        <div class="admin-stat-note">Apartados de cita</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label">Renovaciones</div>
        <div class="admin-stat-value">18</div>
        <div class="admin-stat-note">Planes activos del mes</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todos</span>
    <span class="admin-filter-chip">Pagados</span>
    <span class="admin-filter-chip">Pendientes</span>
    <span class="admin-filter-chip">Reservas</span>
    <span class="admin-filter-chip">Mensualidades</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar usuario, folio o servicio...">
    </div>
</div>

<div class="admin-panel mb-4">
    <div class="admin-panel-head">
        <h2 class="admin-panel-title">Movimientos recientes</h2>
        <span class="small text-muted">Demo visual</span>
    </div>

    <div class="admin-panel-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Servicio</th>
                        <th>Método</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>
                                <strong>{{ $payment['user'] }}</strong>
                                <div class="small text-muted">{{ $payment['note'] }}</div>
                            </td>
                            <td>{{ $payment['service'] }}</td>
                            <td>{{ $payment['method'] }}</td>
                            <td><strong>{{ $payment['amount'] }}</strong></td>
                            <td>{{ $payment['date'] }}</td>
                            <td>
                                <span class="admin-tag {{ $payment['status'] === 'Pagado' ? 'blue' : 'yellow' }}">
                                    {{ $payment['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="admin-form-card h-100">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Registrar pago manual</h2>
                <div class="admin-mini">Para efectivo, transferencia o comprobantes enviados por WhatsApp.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Usuario</label>
                        <input type="text" class="form-control input-soft" placeholder="Buscar usuario">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Servicio</label>
                        <select class="form-select input-soft">
                            <option>Reserva de cita</option>
                            <option>Plan de entrenamiento</option>
                            <option>Plan alimentario</option>
                            <option>Rutina + nutrición</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Monto</label>
                        <input type="text" class="form-control input-soft" placeholder="$0.00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Método</label>
                        <select class="form-select input-soft">
                            <option>Mercado Pago</option>
                            <option>Transferencia</option>
                            <option>Efectivo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select input-soft">
                            <option>Pagado</option>
                            <option>Por confirmar</option>
                            <option>Pendiente</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Notas</label>
                        <textarea class="form-control input-soft py-3" rows="3" placeholder="Referencia, folio, observaciones o acuerdo de pago."></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary-custom">Guardar pago</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="admin-form-card h-100">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Reglas de cobro</h2>
                <div class="admin-mini">Lo que se mostrará después en checkout y confirmaciones.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Apartado de cita</div>
                                <div class="small text-muted">Reserva simbólica para presencial u online.</div>
                            </div>
                            <strong>$100</strong>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Pago online</div>
                                <div class="small text-muted">Online acepta Mercado Pago como método principal.</div>
                            </div>
                            <span class="admin-tag blue">Activo</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold">Efectivo en cita</div>
                                <div class="small text-muted">Disponible solo para valoración presencial.</div>
                            </div>
                            <span class="admin-tag">Presencial</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
