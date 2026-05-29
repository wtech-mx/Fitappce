@extends('layouts.fitapp-admin')

@section('title', 'Nueva medicion | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-rulers me-2 text-primary-custom"></i>Nueva medicion</h1>
        <div class="admin-topbar-subtitle">Captura medidas por cita para crear historial y ver progreso del usuario.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <button type="submit" form="measurementForm" class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> Guardar medicion</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('fitapp.admin.mediciones.store') }}" id="measurementForm">
    @csrf

    <div class="admin-create-layout">
        <div class="admin-section-stack">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="admin-section-heading">
                        <div class="admin-section-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div>
                            <h2 class="admin-panel-title mb-1">Datos de la cita</h2>
                            <div class="admin-mini">Cada medicion queda ligada a un cliente y fecha.</div>
                        </div>
                    </div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-circle"></i>Usuario</label>
                            <select class="form-select input-soft" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $selectedUser?->id) == $user->id)>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-event"></i>Fecha de medicion</label>
                            <input type="date" name="measured_at" class="form-control input-soft" value="{{ old('measured_at', now()->toDateString()) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clipboard2-check"></i>Tipo de cita</label>
                            <select class="form-select input-soft" name="appointment_type" required>
                                <option @selected(old('appointment_type') === 'Valoracion inicial')>Valoracion inicial</option>
                                <option @selected(old('appointment_type') === 'Seguimiento mensual')>Seguimiento mensual</option>
                                <option @selected(old('appointment_type') === 'Renovacion de plan')>Renovacion de plan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="admin-section-heading">
                        <div class="admin-section-icon warn">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div>
                            <h2 class="admin-panel-title mb-1">Composicion corporal</h2>
                            <div class="admin-mini">Valores principales para seguimiento mensual.</div>
                        </div>
                    </div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-speedometer2"></i>Peso kg</label><input type="number" step="0.01" name="weight" class="form-control input-soft" value="{{ old('weight', $selectedUser?->initial_weight) }}" placeholder="65.30"></div>
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-droplet-half"></i>Grasa %</label><input type="number" step="0.01" name="body_fat" class="form-control input-soft" value="{{ old('body_fat', $selectedUser?->initial_body_fat) }}" placeholder="14.73"></div>
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-lightning-charge"></i>Masa magra kg</label><input type="number" step="0.01" name="lean_mass" class="form-control input-soft" value="{{ old('lean_mass', $selectedUser?->initial_lean_mass) }}" placeholder="55.68"></div>
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pie-chart"></i>Masa grasa kg</label><input type="number" step="0.01" name="fat_mass" class="form-control input-soft" value="{{ old('fat_mass') }}" placeholder="9.62"></div>
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-bullseye"></i>Meta grasa %</label><input type="number" step="0.01" name="target_body_fat" class="form-control input-soft" value="{{ old('target_body_fat') }}" placeholder="14.00"></div>
                        <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-bullseye"></i>Meta peso kg</label><input type="number" step="0.01" name="target_weight" class="form-control input-soft" value="{{ old('target_weight') }}" placeholder="65.30"></div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="admin-section-heading">
                        <div class="admin-section-icon danger">
                            <i class="bi bi-arrows-angle-expand"></i>
                        </div>
                        <div>
                            <h2 class="admin-panel-title mb-1">Perimetros corporales</h2>
                            <div class="admin-mini">Centimetros principales para comparar avances.</div>
                        </div>
                    </div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrows-collapse"></i>Cintura cm</label><input type="number" step="0.01" name="waist" class="form-control input-soft" value="{{ old('waist', $selectedUser?->initial_waist) }}" placeholder="81.20"></div>
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-arms-up"></i>Torax cm</label><input type="number" step="0.01" name="chest" class="form-control input-soft" value="{{ old('chest', $selectedUser?->initial_chest) }}" placeholder="97.00"></div>
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-universal-access"></i>Cadera cm</label><input type="number" step="0.01" name="hip" class="form-control input-soft" value="{{ old('hip', $selectedUser?->initial_hip) }}" placeholder="92.50"></div>
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-lightning-charge"></i>Brazo flexionado cm</label><input type="number" step="0.01" name="arm" class="form-control input-soft" value="{{ old('arm', $selectedUser?->initial_arm) }}" placeholder="33.80"></div>
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrow-down-up"></i>Muslo cm</label><input type="number" step="0.01" name="thigh" class="form-control input-soft" value="{{ old('thigh', $selectedUser?->initial_thigh) }}" placeholder="56.10"></div>
                        <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-circle"></i>Pantorrilla cm</label><input type="number" step="0.01" name="calf" class="form-control input-soft" value="{{ old('calf') }}" placeholder="36.20"></div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Notas del coach</h2>
                    <div class="admin-mini">Observaciones para recordar ajustes del plan.</div>
                </div>
                <div class="admin-form-card-body">
                    <textarea name="notes" class="form-control input-soft py-3" rows="4" placeholder="Ej. Mejoro adherencia, ajustar calorias, revisar tecnica de sentadilla.">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="admin-sticky-col">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Resumen rapido</h2>
                    <div class="admin-mini">Se guardara en el historial del cliente.</div>
                </div>

                <div class="admin-form-card-body">
                    <div class="admin-stat-inline mb-3">
                        <div class="admin-stat-inline-card">
                            <i class="bi bi-speedometer2 text-primary-custom mb-2"></i>
                            <div class="value">{{ $selectedUser?->initial_weight ?: '-' }}</div>
                            <div class="label">Peso inicial</div>
                        </div>
                        <div class="admin-stat-inline-card">
                            <i class="bi bi-droplet-half text-primary-custom mb-2"></i>
                            <div class="value">{{ $selectedUser?->initial_body_fat ?: '-' }}</div>
                            <div class="label">Grasa inicial</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100"><i class="bi bi-check2-circle me-1"></i> Guardar medicion</button>
                </div>
            </div>

            <div class="admin-helper-note">
                <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1 text-primary-custom"></i>Registro por cita</div>
                <div class="admin-mini">
                    Cada captura crea un registro historico. No sobrescribe mediciones anteriores.
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
