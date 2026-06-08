@extends('layouts.fitapp-admin')

@section('title', ($mode === 'edit' ? 'Editar' : 'Crear').' logro | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $mode === 'edit' ? 'Editar logro' : 'Crear logro' }}</h1>
        <div class="admin-topbar-subtitle">Define el texto, la imagen y la condicion que desbloquea el trofeo.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.logros') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button type="submit" form="achievementForm" class="btn btn-primary-custom px-4">Guardar logro</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ $mode === 'edit' && $achievement ? route('fitapp.admin.logros.update', $achievement) : route('fitapp.admin.logros.store') }}" enctype="multipart/form-data" id="achievementForm">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="admin-detail-layout">
        <div class="admin-section-stack">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Informacion del logro</h2>
                    <div class="admin-mini">Este texto es el que vera el cliente en su vitrina.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del logro</label>
                            <input type="text" name="name" value="{{ old('name', $achievement?->name) }}" class="form-control input-soft" placeholder="Fuego Interior" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Categoria</label>
                            <select name="category" class="form-select input-soft" required>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" @selected(old('category', $achievement?->category ?? 'habits') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Meta que vera el cliente</label>
                            <textarea name="goal_text" class="form-control input-soft py-3" rows="4" required>{{ old('goal_text', $achievement?->goal_text) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Regla de desbloqueo</h2>
                    <div class="admin-mini">Guarda la condicion que luego se evaluara con check-ins, rutinas, agua o medidas.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Se desbloquea cuando...</label>
                            <select name="trigger_type" class="form-select input-soft" required>
                                @foreach($triggers as $key => $label)
                                    <option value="{{ $key }}" @selected(old('trigger_type', $achievement?->trigger_type ?? 'manual') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Cantidad/meta</label>
                            <input type="number" name="target_count" value="{{ old('target_count', $achievement?->target_count) }}" class="form-control input-soft" min="1" placeholder="7">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Unidad</label>
                            <input type="text" name="target_unit" value="{{ old('target_unit', $achievement?->target_unit) }}" class="form-control input-soft" placeholder="dias seguidos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-sticky-col">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Imagen del trofeo</h2>
                    <div class="admin-mini">Puedes subir PNG o JPG. Si no hay imagen, se usa un trofeo base.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="achievement-image-preview mb-3">
                        @if($achievement?->imageUrl())
                            <img src="{{ $achievement->imageUrl() }}" alt="{{ $achievement->name }}">
                        @else
                            <i class="bi bi-trophy-fill"></i>
                        @endif
                    </div>
                    <input type="file" name="image" class="form-control input-soft" accept="image/*">
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Estado</h2>
                    <div class="admin-mini">Los logros activos aparecen en la vitrina del cliente.</div>
                </div>
                <div class="admin-form-card-body">
                    <label class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <span class="fw-bold">Mostrar al cliente</span>
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $achievement?->is_active ?? true))>
                    </label>
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2">Guardar logro</button>
                    <a href="{{ route('fitapp.admin.logros') }}" class="btn btn-soft-custom w-100">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
