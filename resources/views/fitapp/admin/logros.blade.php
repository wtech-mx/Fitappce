@extends('layouts.fitapp-admin')

@section('title', 'Logros | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-trophy me-2 text-primary-custom"></i>Logros</h1>
        <div class="admin-topbar-subtitle">Configura trofeos, reglas de desbloqueo e imagenes para la vitrina del cliente.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.logros.crear') }}" class="btn btn-primary-custom px-4">Nuevo logro</a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label">Logros activos</div>
        <div class="admin-stat-value">{{ $achievements->where('is_active', true)->count() }}</div>
        <div class="admin-stat-note">Visibles al cliente</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Total logros</div>
        <div class="admin-stat-value">{{ $achievements->count() }}</div>
        <div class="admin-stat-note">Catalogo completo</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Desbloqueos</div>
        <div class="admin-stat-value">{{ $achievements->sum('unlocked_count') }}</div>
        <div class="admin-stat-note">Trofeos ganados</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label">Reglas</div>
        <div class="admin-stat-value">{{ $achievements->pluck('trigger_type')->unique()->count() }}</div>
        <div class="admin-stat-note">Tipos de meta</div>
    </div>
</div>

<div class="admin-filter-bar">
    <span class="admin-filter-chip active">Todos</span>
    <form method="GET" action="{{ route('fitapp.admin.logros') }}" class="ms-auto admin-search">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar logro o meta...">
    </form>
</div>

@if($achievements->isEmpty())
    <div class="admin-helper-note">
        <div class="fw-bold mb-1">Sin logros capturados</div>
        <div class="admin-mini mb-3">Crea el primer logro para empezar a construir la vitrina del cliente.</div>
        <a href="{{ route('fitapp.admin.logros.crear') }}" class="btn btn-primary-custom">Nuevo logro</a>
    </div>
@else
    <div class="admin-card-grid">
        @foreach($achievements as $achievement)
            <div class="admin-routine-card">
                <div class="admin-card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <div class="d-flex gap-3">
                            <div class="achievement-admin-icon">
                                @if($achievement->imageUrl())
                                    <img src="{{ $achievement->imageUrl() }}" alt="{{ $achievement->name }}">
                                @else
                                    <i class="bi bi-trophy-fill"></i>
                                @endif
                            </div>
                            <div>
                                <div class="admin-card-title">{{ $achievement->name }}</div>
                                <div class="admin-card-text">{{ $achievement->categoryLabel() }}</div>
                            </div>
                        </div>
                        <span class="admin-tag {{ $achievement->is_active ? 'blue' : 'yellow' }}">{{ $achievement->is_active ? 'Activo' : 'Oculto' }}</span>
                    </div>

                    <div class="routine-purpose-box mb-3">
                        <div class="admin-mini mb-1">Meta</div>
                        <div class="fw-bold">{{ $achievement->goal_text }}</div>
                    </div>

                    <div class="routine-meta-strip mb-3">
                        <span><i class="bi bi-sliders"></i> {{ $achievement->triggerLabel() }}</span>
                        <span><i class="bi bi-bullseye"></i> {{ $achievement->target_count ?: '-' }} {{ $achievement->target_unit }}</span>
                        <span><i class="bi bi-unlock"></i> {{ $achievement->unlocked_count }} ganados</span>
                    </div>

                    <form method="POST" action="{{ route('fitapp.admin.logros.unlock', $achievement) }}" class="achievement-unlock-form mb-3">
                        @csrf
                        <select name="user_id" class="form-select input-soft" required>
                            <option value="">Desbloquear para...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="source_note" class="form-control input-soft" placeholder="Nota opcional">
                        <button type="submit" class="admin-btn-soft justify-content-center">
                            <i class="bi bi-gift"></i> Desbloquear
                        </button>
                    </form>

                    <div class="admin-card-actions">
                        <a href="{{ route('fitapp.admin.logros.edit', $achievement) }}" class="admin-btn-soft"><i class="bi bi-pencil"></i> Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
