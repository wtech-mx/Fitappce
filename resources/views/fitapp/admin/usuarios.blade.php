@extends('layouts.fitapp-admin')

@section('title', 'Usuarios | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Usuarios</h1>
        <div class="admin-topbar-subtitle">Prospectos, activos y alumnos con plan personalizado o preconfigurado.</div>
    </div>

    <div class="admin-topbar-actions">
        <button class="btn btn-primary-custom px-4">Nuevo usuario</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todos</span>
    <span class="admin-filter-chip">Prospectos</span>
    <span class="admin-filter-chip">Activos</span>
    <span class="admin-filter-chip">Pendientes de cita</span>
    <span class="admin-filter-chip">Personalizados</span>

    <div class="ms-auto admin-search">
        <input type="text" class="form-control input-soft" placeholder="Buscar por nombre, plan o teléfono...">
    </div>
</div>

<div class="admin-card-grid">
    <div class="admin-user-card">
        <div class="admin-card-body">
            <div class="d-flex gap-3 mb-3">
                <div class="admin-avatar-lg">M</div>
                <div>
                    <div class="admin-card-title">María González</div>
                    <div class="admin-card-text">Masa muscular · Rutina + nutrición</div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag blue">Activa</span>
                <span class="admin-tag">Personalizado</span>
                <span class="admin-tag yellow">Cita 09 Abr</span>
            </div>

            <div class="admin-card-text">
                Entrena en gimnasio · 3 días por semana · seguimiento con coach.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-person-vcard"></i> Ver perfil</a>
                <a href="{{ route('fitapp.admin.rutinas') }}" class="admin-btn-soft"><i class="bi bi-activity"></i> Rutina</a>
            </div>
        </div>
    </div>

    <div class="admin-user-card">
        <div class="admin-card-body">
            <div class="d-flex gap-3 mb-3">
                <div class="admin-avatar-lg">J</div>
                <div>
                    <div class="admin-card-title">Jorge Ramírez</div>
                    <div class="admin-card-text">Definición · Solo rutina</div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag yellow">Pendiente</span>
                <span class="admin-tag">Preconfigurado</span>
            </div>

            <div class="admin-card-text">
                Ya reservó valoración inicial. Aún no se genera rutina final.
            </div>

            <div class="admin-card-actions">
                <a href="#" class="admin-btn-soft"><i class="bi bi-calendar-check"></i> Cita</a>
                <a href="#" class="admin-btn-soft"><i class="bi bi-chat-left-text"></i> Contacto</a>
            </div>
        </div>
    </div>

    <div class="admin-user-card">
        <div class="admin-card-body">
            <div class="d-flex gap-3 mb-3">
                <div class="admin-avatar-lg">F</div>
                <div>
                    <div class="admin-card-title">Fernanda Ruiz</div>
                    <div class="admin-card-text">Pérdida de peso · Nutrición</div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="admin-tag blue">Activa</span>
                <span class="admin-tag">Plan nutricional</span>
            </div>

            <div class="admin-card-text">
                Tiene fotos de comida pendientes de revisión y plan semanal vigente.
            </div>

            <div class="admin-card-actions">
                <a href="{{ route('fitapp.admin.nutricion') }}" class="admin-btn-soft"><i class="bi bi-journal-medical"></i> Plan</a>
                <a href="{{ route('fitapp.admin.evidencias') }}" class="admin-btn-soft"><i class="bi bi-images"></i> Evidencias</a>
            </div>
        </div>
    </div>
</div>
@endsection
