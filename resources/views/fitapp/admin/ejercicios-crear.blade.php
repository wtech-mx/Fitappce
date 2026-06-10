@extends('layouts.fitapp-admin')

@section('title', ($mode === 'edit' ? 'Editar' : 'Crear').' ejercicio | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">{{ $mode === 'edit' ? 'Editar ejercicio' : 'Crear ejercicio' }}</h1>
        <div class="admin-topbar-subtitle">Sube demo, clasifica el ejercicio y escribe las indicaciones que vera el cliente.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button type="submit" form="exerciseForm" class="btn btn-primary-custom px-4">Guardar ejercicio</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ $mode === 'edit' && $exercise ? route('fitapp.admin.ejercicios.update', $exercise) : route('fitapp.admin.ejercicios.store') }}" enctype="multipart/form-data" id="exerciseForm">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="admin-detail-layout">
        <div class="admin-section-stack">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Datos generales</h2>
                    <div class="admin-mini">Nombre, clasificacion y nivel.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre del ejercicio</label>
                            <input type="text" name="name" value="{{ old('name', $exercise?->name) }}" class="form-control input-soft" placeholder="Hip Thrust" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nivel</label>
                            <input list="exerciseLevels" type="text" name="level" value="{{ old('level', $exercise?->level) }}" class="form-control input-soft" placeholder="Intermedio">
                            <datalist id="exerciseLevels">
                                @foreach($options['levels'] as $level)
                                    <option value="{{ $level }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Categoria padre</label>
                            <input list="parentOptions" type="text" name="parent_category" value="{{ old('parent_category', $exercise?->parent_category) }}" class="form-control input-soft" placeholder="Tren inferior">
                            <datalist id="parentOptions">
                                @foreach($options['parents'] as $option)
                                    <option value="{{ $option }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Categoria</label>
                            <input list="categoryOptions" type="text" name="category" value="{{ old('category', $exercise?->category) }}" class="form-control input-soft" placeholder="Gluteo">
                            <datalist id="categoryOptions">
                                @foreach($options['categories'] as $option)
                                    <option value="{{ $option }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Subcategoria</label>
                            <input list="subcategoryOptions" type="text" name="subcategory" value="{{ old('subcategory', $exercise?->subcategory) }}" class="form-control input-soft" placeholder="Hip Thrust">
                            <datalist id="subcategoryOptions">
                                @foreach($options['subcategories'] as $option)
                                    <option value="{{ $option }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Musculo principal</label>
                            <input type="text" name="primary_muscle" value="{{ old('primary_muscle', $exercise?->primary_muscle) }}" class="form-control input-soft" placeholder="Gluteo mayor">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Musculos trabajados</label>
                            <input type="text" name="muscles" value="{{ old('muscles', $exercise?->muscles) }}" class="form-control input-soft" placeholder="Gluteo mayor, femoral, core">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripcion breve</label>
                            <textarea name="description" class="form-control input-soft py-3" rows="3">{{ old('description', $exercise?->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Contenido para el cliente</h2>
                    <div class="admin-mini">Se muestra cuando abre el ejercicio en su rutina.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Para que sirve</label>
                            <textarea name="purpose" class="form-control input-soft py-3" rows="3">{{ old('purpose', $exercise?->purpose) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Indicaciones del coach</label>
                            <textarea name="coach_notes" class="form-control input-soft py-3" rows="4">{{ old('coach_notes', $exercise?->coach_notes) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Errores comunes</label>
                            <textarea name="common_mistakes" class="form-control input-soft py-3" rows="4">{{ old('common_mistakes', $exercise?->common_mistakes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-sticky-col">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Demo</h2>
                    <div class="admin-mini">Video, GIF o imagen del ejercicio.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="exercise-demo-preview mb-3">
                        @include('fitapp.partials.exercise-demo', [
                            'exercise' => $exercise,
                            'emptyTitle' => 'Sube demo o pega URL',
                        ])
                    </div>

                    <label class="form-label fw-bold">Tipo</label>
                    <select name="demo_type" class="form-select input-soft mb-3">
                        @foreach(['video' => 'Video', 'gif' => 'GIF', 'image' => 'Imagen'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('demo_type', $exercise?->demo_type ?? 'video') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>

                    <label class="form-label fw-bold">Origen del demo</label>
                    <div class="d-grid gap-2 mb-3">
                        <label class="exercise-source-option">
                            <input type="radio" name="demo_source" value="upload" @checked(old('demo_source', $exercise?->demo_source ?? 'upload') === 'upload')>
                            <span><strong>Subir archivo</strong><small>MP4, WebM, MOV, GIF o imagen.</small></span>
                        </label>
                        <label class="exercise-source-option">
                            <input type="radio" name="demo_source" value="url" @checked(old('demo_source', $exercise?->demo_source) === 'url')>
                            <span><strong>URL externa</strong><small>YouTube, Drive u otra liga.</small></span>
                        </label>
                    </div>

                    <label class="form-label fw-bold">Archivo</label>
                    <input type="file" name="demo" class="form-control input-soft mb-3" accept="video/mp4,video/webm,video/quicktime,image/gif,image/png,image/jpeg">

                    <label class="form-label fw-bold">URL de YouTube o Drive</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $exercise?->demo_url) }}" class="form-control input-soft" placeholder="https://www.youtube.com/watch?v=...">
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Uso en rutinas</h2>
                    <div class="admin-mini">Controla disponibilidad y evidencias.</div>
                </div>
                <div class="admin-form-card-body">
                    <label class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <span class="fw-bold">Permitir evidencia</span>
                        <input type="checkbox" name="allows_evidence" value="1" @checked(old('allows_evidence', $exercise?->allows_evidence ?? true))>
                    </label>
                    <label class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <span class="fw-bold">Destacado</span>
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $exercise?->is_featured ?? false))>
                    </label>
                    <label class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <span class="fw-bold">Activo</span>
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $exercise?->is_active ?? true))>
                    </label>

                    <button type="submit" class="btn btn-primary-custom w-100 mb-2">Guardar ejercicio</button>
                    <a href="{{ route('fitapp.admin.ejercicios') }}" class="btn btn-soft-custom w-100">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
