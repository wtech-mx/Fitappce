@extends('layouts.fitapp-admin')

@section('title', 'Biblioteca de ejercicios | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Biblioteca de ejercicios</h1>
        <div class="admin-topbar-subtitle">Catalogo real con categorias, descripcion tecnica y videos demo reutilizables en rutinas.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="btn btn-primary-custom px-4">
            Nuevo ejercicio
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success rounded-4 mb-4">{{ session('status') }}</div>
@endif

<div class="admin-taxonomy-layout">
    <section class="admin-tree-panel">
        <div class="admin-tree-head">
            <h2 class="admin-panel-title mb-1">Categorias</h2>
            <div class="admin-mini">Agrupadas desde ejercicios guardados</div>
        </div>

        <div class="admin-tree-body">
            @forelse($taxonomy as $parent => $categories)
                <div class="admin-tree-group">
                    <div class="admin-tree-parent">{{ $parent }}</div>

                    @foreach($categories as $category => $subcategories)
                        <div class="admin-tree-category {{ $loop->first ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="fw-bold">{{ $category }}</div>
                                    <div class="admin-mini">{{ $subcategories->count() }} subcategorias</div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>

                            <div class="admin-tree-subs">
                                @foreach($subcategories as $subcategory)
                                    <span class="admin-tree-sub">{{ $subcategory }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="admin-helper-note mb-0">Aun no hay categorias porque no has creado ejercicios.</div>
            @endforelse
        </div>
    </section>

    <section class="admin-work-panel">
        <div class="admin-work-head">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h2 class="admin-panel-title mb-1">Ejercicios</h2>
                    <div class="admin-mini">Disponibles para seleccionar al crear rutinas.</div>
                </div>

                <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="admin-btn-soft">
                    <i class="bi bi-plus-circle"></i> Nuevo ejercicio
                </a>
            </div>
        </div>

        <div class="admin-work-body">
            <div class="admin-toolbar">
                <span class="admin-count-badge"><i class="bi bi-diagram-3"></i> {{ $exercises->pluck('parent_category')->filter()->unique()->count() }} categorias padre</span>
                <span class="admin-count-badge"><i class="bi bi-tags"></i> {{ $exercises->pluck('category')->filter()->unique()->count() }} categorias</span>
                <span class="admin-count-badge"><i class="bi bi-collection"></i> {{ $exercises->count() }} ejercicios</span>
            </div>

            <div class="admin-filter-bar">
                <span class="admin-filter-chip active">Todos</span>
                <form method="GET" action="{{ route('fitapp.admin.ejercicios') }}" class="ms-auto admin-search">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control input-soft" placeholder="Buscar ejercicio...">
                </form>
            </div>

            @if($exercises->isEmpty())
                <div class="admin-helper-note">
                    <div class="fw-bold mb-1">Sin ejercicios capturados</div>
                    <div class="admin-mini mb-3">Crea el primer ejercicio para empezar a armar rutinas desde catalogo.</div>
                    <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="btn btn-primary-custom">Nuevo ejercicio</a>
                </div>
            @else
                <div class="admin-card-grid">
                    @foreach($exercises as $exercise)
                        <div class="admin-exercise-card">
                            <div class="admin-card-cover exercise-cover-media">
                                @if($exercise->demoUrl() && $exercise->demo_type === 'image' && $exercise->demo_source === 'upload')
                                    <img src="{{ $exercise->demoUrl() }}" alt="{{ $exercise->name }}">
                                @else
                                    <i class="bi {{ $exercise->demoUrl() ? ($exercise->demo_source === 'url' ? 'bi-link-45deg' : 'bi-play-circle-fill') : 'bi-camera-reels' }}"></i>
                                @endif
                            </div>

                            <div class="admin-card-body">
                                <div class="d-flex gap-3 mb-3">
                                    <div class="admin-thumb">
                                        <i class="bi bi-activity"></i>
                                    </div>
                                    <div>
                                        <div class="admin-card-title">{{ $exercise->name }}</div>
                                        <div class="admin-card-text">
                                            {{ $exercise->category ?: 'Sin categoria' }} - {{ $exercise->subcategory ?: 'Sin subcategoria' }} - {{ $exercise->level ?: 'Sin nivel' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @if($exercise->parent_category)<span class="admin-tag">{{ $exercise->parent_category }}</span>@endif
                                    @if($exercise->category)<span class="admin-tag">{{ $exercise->category }}</span>@endif
                                    @if($exercise->subcategory)<span class="admin-tag blue">{{ $exercise->subcategory }}</span>@endif
                                    <span class="admin-tag {{ $exercise->is_active ? 'blue' : 'yellow' }}">{{ $exercise->is_active ? 'Activo' : 'Oculto' }}</span>
                                </div>

                                <div class="admin-card-text">
                                    {{ $exercise->description ?: 'Sin descripcion capturada.' }}
                                </div>

                                <div class="admin-card-actions">
                                    <a href="{{ route('fitapp.admin.ejercicios.detalle', $exercise) }}" class="admin-btn-soft">
                                        <i class="bi bi-play-circle"></i> Ver demo
                                    </a>
                                    <a href="{{ route('fitapp.admin.ejercicios.edit', $exercise) }}" class="admin-btn-soft">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
