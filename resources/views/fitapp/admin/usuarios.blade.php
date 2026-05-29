@extends('layouts.fitapp-admin')

@section('title', 'Usuarios | FitCoach Admin')

@section('content')
@php
    $statusLabels = [
        'prospect' => ['label' => 'Prospecto', 'class' => ''],
        'active' => ['label' => 'Activo', 'class' => 'blue'],
        'appointment_pending' => ['label' => 'Pendiente de cita', 'class' => 'yellow'],
        'paused' => ['label' => 'Pausado', 'class' => 'red'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Usuarios</h1>
        <div class="admin-topbar-subtitle">Prospectos, activos y alumnos con plan personalizado o preconfigurado.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.usuarios.alta') }}" class="btn btn-primary-custom px-4">Nuevo usuario</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">
        {{ session('status') }}
    </div>
@endif

<div class="admin-filter-bar">
    <a href="{{ route('fitapp.admin.usuarios', request()->only('q')) }}" class="admin-filter-chip {{ request('status') ? '' : 'active' }}">Todos</a>
    <a href="{{ route('fitapp.admin.usuarios', ['status' => 'prospect', 'q' => request('q')]) }}" class="admin-filter-chip {{ request('status') === 'prospect' ? 'active' : '' }}">Prospectos</a>
    <a href="{{ route('fitapp.admin.usuarios', ['status' => 'active', 'q' => request('q')]) }}" class="admin-filter-chip {{ request('status') === 'active' ? 'active' : '' }}">Activos</a>
    <a href="{{ route('fitapp.admin.usuarios', ['status' => 'appointment_pending', 'q' => request('q')]) }}" class="admin-filter-chip {{ request('status') === 'appointment_pending' ? 'active' : '' }}">Pendientes de cita</a>

    <form method="GET" action="{{ route('fitapp.admin.usuarios') }}" class="ms-auto admin-search">
        @if (request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar por nombre, objetivo o telefono...">
    </form>
</div>

@if ($users->isEmpty())
    <div class="admin-helper-note">
        <div class="fw-bold mb-1">Sin usuarios todavía</div>
        <div class="admin-mini mb-3">Crea el primer cliente para empezar a vincular planes, rutinas, mediciones y seguimiento.</div>
        <a href="{{ route('fitapp.admin.usuarios.alta') }}" class="btn btn-primary-custom">Nuevo usuario</a>
    </div>
@else
    <div class="admin-card-grid">
        @foreach ($users as $user)
            @php
                $status = $statusLabels[$user->status] ?? $statusLabels['prospect'];
            @endphp

            <div class="admin-user-card">
                <div class="admin-card-body">
                    <div class="d-flex gap-3 mb-3">
                        <div class="admin-avatar-lg">{{ $user->initials() }}</div>
                        <div>
                            <div class="admin-card-title">{{ $user->name }}</div>
                            <div class="admin-card-text">{{ $user->goal ?: 'Objetivo pendiente' }} · {{ $user->service ?: 'Servicio pendiente' }}</div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="admin-tag {{ $status['class'] }}">{{ $status['label'] }}</span>
                        @if ($user->plan_type)
                            <span class="admin-tag">{{ $user->plan_type }}</span>
                        @endif
                        @if ($user->training_place)
                            <span class="admin-tag yellow">{{ $user->training_place }}</span>
                        @endif
                    </div>

                    <div class="admin-card-text">
                        {{ $user->phone ?: 'Sin telefono capturado' }} · {{ $user->training_days ? $user->training_days.' dias por semana' : 'Frecuencia pendiente' }} · {{ $user->training_level ?: 'Nivel pendiente' }}.
                    </div>

                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.usuarios.detalle', $user) }}" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Ver perfil</a>
                        <a href="{{ route('fitapp.admin.usuarios.edit', $user) }}" class="admin-btn-soft"><i class="bi bi-pencil-square"></i> Editar</a>
                        <a href="{{ route('fitapp.admin.planes', ['user' => $user->id]) }}" class="admin-btn-soft"><i class="bi bi-clipboard2-pulse"></i> Planes</a>
                        <a href="{{ route('fitapp.admin.rutinas') }}" class="admin-btn-soft"><i class="bi bi-activity"></i> Rutina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
