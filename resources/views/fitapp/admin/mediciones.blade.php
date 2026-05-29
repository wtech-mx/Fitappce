@extends('layouts.fitapp-admin')

@section('title', 'Mediciones | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-rulers me-2 text-primary-custom"></i>Mediciones</h1>
        <div class="admin-topbar-subtitle">Cada cita genera un registro de medicion para consultar historial y progreso corporal.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="btn btn-primary-custom px-4"><i class="bi bi-plus-circle me-1"></i> Nueva medicion</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">
        {{ session('status') }}
    </div>
@endif

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-calendar3 me-1 text-primary-custom"></i>Mediciones totales</div>
        <div class="admin-stat-value">{{ $measurements->count() }}</div>
        <div class="admin-stat-note">Registros capturados</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-check2-circle me-1 text-primary-custom"></i>Clientes medidos</div>
        <div class="admin-stat-value">{{ $measurements->pluck('user_id')->unique()->count() }}</div>
        <div class="admin-stat-note">Con historial corporal</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-droplet-half me-1 text-primary-custom"></i>Promedio grasa</div>
        <div class="admin-stat-value">{{ $measurements->whereNotNull('body_fat')->avg('body_fat') ? number_format($measurements->whereNotNull('body_fat')->avg('body_fat'), 1) : '-' }}</div>
        <div class="admin-stat-note">Porcentaje promedio</div>
    </div>

    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-arrow-repeat me-1 text-primary-custom"></i>Ultima captura</div>
        <div class="admin-stat-value">{{ $latest?->measured_at?->format('d/m') ?: '-' }}</div>
        <div class="admin-stat-note">{{ $latest?->user?->name ?: 'Sin registros' }}</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active"><i class="bi bi-grid me-1"></i>Todas</span>

    <form method="GET" action="{{ route('fitapp.admin.mediciones') }}" class="ms-auto admin-search">
        @if (request('user'))
            <input type="hidden" name="user" value="{{ request('user') }}">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar usuario o correo...">
    </form>
</div>

<div class="admin-detail-layout">
    <div class="admin-section-stack">
        <div class="admin-panel">
            <div class="admin-panel-head">
                <h2 class="admin-panel-title"><i class="bi bi-clock-history me-2 text-primary-custom"></i>Historial de mediciones</h2>
                <span class="small text-muted"><i class="bi bi-database-check me-1"></i>Datos reales</span>
            </div>

            <div class="admin-panel-body">
                @if ($measurements->isEmpty())
                    <div class="admin-helper-note">
                        <div class="fw-bold mb-1">Sin mediciones todavía</div>
                        <div class="admin-mini mb-3">Crea la primera medicion para alimentar el expediente corporal de un cliente.</div>
                        <a href="{{ route('fitapp.admin.mediciones.crear') }}" class="btn btn-primary-custom">Nueva medicion</a>
                    </div>
                @else
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Cita</th>
                                    <th>Peso</th>
                                    <th>Grasa</th>
                                    <th>Masa magra</th>
                                    <th>Cintura</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($measurements as $measurement)
                                    <tr>
                                        <td>
                                            <strong><i class="bi bi-person-circle me-1 text-primary-custom"></i>{{ $measurement->user->name }}</strong>
                                            <div class="small text-muted">{{ $measurement->user->email }}</div>
                                        </td>
                                        <td><i class="bi bi-calendar-event me-1 text-primary-custom"></i>{{ $measurement->measured_at->format('d/m/Y') }}</td>
                                        <td><i class="bi bi-clipboard2-check me-1 text-primary-custom"></i>{{ $measurement->appointment_type }}</td>
                                        <td><i class="bi bi-speedometer2 me-1 text-primary-custom"></i>{{ $measurement->weight ? $measurement->weight.' kg' : '-' }}</td>
                                        <td><i class="bi bi-droplet-half me-1 text-primary-custom"></i>{{ $measurement->body_fat ? $measurement->body_fat.'%' : '-' }}</td>
                                        <td><i class="bi bi-lightning-charge me-1 text-primary-custom"></i>{{ $measurement->lean_mass ? $measurement->lean_mass.' kg' : '-' }}</td>
                                        <td><i class="bi bi-arrows-collapse me-1 text-primary-custom"></i>{{ $measurement->waist ? $measurement->waist.' cm' : '-' }}</td>
                                        <td>
                                            <a href="{{ route('fitapp.admin.usuarios.detalle', $measurement->user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Ver usuario</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        @if ($latest)
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="admin-section-heading">
                        <div class="admin-section-icon warn">
                            <i class="bi bi-clipboard2-data-fill"></i>
                        </div>
                        <div>
                            <h2 class="admin-panel-title mb-1">Ultimo registro capturado</h2>
                            <div class="admin-mini">{{ $latest->user->name }} - {{ $latest->measured_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>

                <div class="admin-form-card-body">
                    <div class="routine-summary-grid mb-3">
                        <div><span><i class="bi bi-droplet-half me-1"></i>Grasa corporal</span><strong>{{ $latest->body_fat ? $latest->body_fat.'%' : '-' }}</strong></div>
                        <div><span><i class="bi bi-lightning-charge me-1"></i>Masa magra</span><strong>{{ $latest->lean_mass ? $latest->lean_mass.' kg' : '-' }}</strong></div>
                        <div><span><i class="bi bi-pie-chart me-1"></i>Masa grasa</span><strong>{{ $latest->fat_mass ? $latest->fat_mass.' kg' : '-' }}</strong></div>
                        <div><span><i class="bi bi-speedometer2 me-1"></i>Peso corporal</span><strong>{{ $latest->weight ? $latest->weight.' kg' : '-' }}</strong></div>
                    </div>

                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.mediciones.crear', ['user' => $latest->user_id]) }}" class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Nueva medicion</a>
                        <a href="{{ route('fitapp.admin.usuarios.detalle', $latest->user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Ver usuario</a>
                        <a href="{{ route('fitapp.admin.mediciones.reporte') }}" class="admin-btn-soft"><i class="bi bi-eye"></i> Ver reporte visual</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Progreso visual</h2>
                        <div class="admin-mini">El siguiente paso sera comparar registros por cliente.</div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-list">
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold"><i class="bi bi-person-check me-1 text-primary-custom"></i>Historial por cliente</div>
                                <div class="small text-muted">Ya puedes capturar multiples mediciones por usuario.</div>
                            </div>
                            <span class="admin-tag blue">Activo</span>
                        </div>
                    </div>
                    <div class="admin-list-item">
                        <div class="admin-list-row">
                            <div>
                                <div class="fw-bold"><i class="bi bi-phone me-1 text-primary-custom"></i>Vista del usuario</div>
                                <div class="small text-muted">Pendiente conectar a /fitapp/progreso.</div>
                            </div>
                            <span class="admin-tag yellow">Siguiente</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1 text-primary-custom"></i>Como funciona</div>
            <div class="admin-mini">
                Cada medicion se guarda como registro historico. El expediente del cliente muestra la mas reciente y el historial completo vive aqui.
            </div>
        </div>
    </div>
</div>
@endsection
