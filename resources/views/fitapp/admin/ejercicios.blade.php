@extends('layouts.fitapp-admin')

@section('title', 'Biblioteca de ejercicios | FitCoach Admin')

@section('content')
@php
    $taxonomy = [
        [
            'parent' => 'Tren superior',
            'categories' => [
                [
                    'name' => 'Espalda',
                    'active' => false,
                    'subs' => ['Jalones', 'Remos', 'Aislamiento']
                ],
                [
                    'name' => 'Pecho',
                    'active' => false,
                    'subs' => ['Empujes', 'Aperturas', 'Máquinas']
                ],
            ],
        ],
        [
            'parent' => 'Tren inferior',
            'categories' => [
                [
                    'name' => 'Pierna',
                    'active' => false,
                    'subs' => ['Cuádriceps', 'Femoral', 'Unilateral']
                ],
                [
                    'name' => 'Glúteo',
                    'active' => true,
                    'subs' => ['Activación', 'Hip Thrust', 'Aislamiento']
                ],
            ],
        ],
    ];

    $exercises = [
        [
            'name' => 'Hip Thrust',
            'parent' => 'Tren inferior',
            'category' => 'Glúteo',
            'subcategory' => 'Hip Thrust',
            'level' => 'Intermedio',
            'desc' => 'Ejercicio base para desarrollo de glúteo y extensión de cadera.',
        ],
        [
            'name' => 'Puente de glúteo con banda',
            'parent' => 'Tren inferior',
            'category' => 'Glúteo',
            'subcategory' => 'Activación',
            'level' => 'Principiante',
            'desc' => 'Ideal para activar glúteo medio y preparar la cadera antes de la rutina.',
        ],
        [
            'name' => 'Patada de glúteo en polea',
            'parent' => 'Tren inferior',
            'category' => 'Glúteo',
            'subcategory' => 'Aislamiento',
            'level' => 'Intermedio',
            'desc' => 'Enfocado en aislamiento de glúteo con recorrido controlado.',
        ],
        [
            'name' => 'Abducción con banda',
            'parent' => 'Tren inferior',
            'category' => 'Glúteo',
            'subcategory' => 'Activación',
            'level' => 'Principiante',
            'desc' => 'Muy útil para estabilidad lateral y activación previa.',
        ],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Biblioteca de ejercicios</h1>
        <div class="admin-topbar-subtitle">
            Catálogo visual por categoría padre, categoría y subcategoría. Todo preparado para luego conectarse a base de datos.
        </div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="btn btn-primary-custom px-4">
            Crear estructura
        </a>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-taxonomy-layout">
    {{-- ÁRBOL / TAXONOMÍA --}}
    <section class="admin-tree-panel">
        <div class="admin-tree-head">
            <h2 class="admin-panel-title mb-1">Categorías dinámicas</h2>
            <div class="admin-mini">Simuladas con arrays en Blade</div>
        </div>

        <div class="admin-tree-body">
            @foreach($taxonomy as $group)
                <div class="admin-tree-group">
                    <div class="admin-tree-parent">{{ $group['parent'] }}</div>

                    @foreach($group['categories'] as $cat)
                        <div class="admin-tree-category {{ $cat['active'] ? 'active' : '' }}">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="fw-bold">{{ $cat['name'] }}</div>
                                    <div class="admin-mini">{{ count($cat['subs']) }} subcategorías</div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>

                            <div class="admin-tree-subs">
                                @foreach($cat['subs'] as $index => $sub)
                                    <span class="admin-tree-sub {{ $cat['active'] && $index === 0 ? 'active' : '' }}">
                                        {{ $sub }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

    {{-- LISTADO DE EJERCICIOS --}}
    <section class="admin-work-panel">
        <div class="admin-work-head">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h2 class="admin-panel-title mb-1">Ejercicios de Glúteo</h2>
                    <div class="admin-mini">Categoría padre: Tren inferior · Subcategorías: Activación / Hip Thrust / Aislamiento</div>
                </div>

                <a href="{{ route('fitapp.admin.ejercicios.crear') }}" class="admin-btn-soft">
                    <i class="bi bi-plus-circle"></i> Nuevo ejercicio
                </a>
            </div>
        </div>

        <div class="admin-work-body">
            <div class="admin-toolbar">
                <span class="admin-count-badge">
                    <i class="bi bi-diagram-3"></i> 2 categorías padre
                </span>
                <span class="admin-count-badge">
                    <i class="bi bi-tags"></i> 4 categorías
                </span>
                <span class="admin-count-badge">
                    <i class="bi bi-collection"></i> {{ count($exercises) }} ejercicios
                </span>
            </div>

            <div class="admin-filter-bar">
                <span class="admin-filter-chip active">Todos</span>
                <span class="admin-filter-chip">Activación</span>
                <span class="admin-filter-chip">Hip Thrust</span>
                <span class="admin-filter-chip">Aislamiento</span>

                <div class="ms-auto admin-search">
                    <input type="text" class="form-control input-soft" placeholder="Buscar ejercicio...">
                </div>
            </div>

            <div class="admin-card-grid">
                @foreach($exercises as $exercise)
                    <div class="admin-exercise-card">
                        <div class="admin-card-cover"></div>

                        <div class="admin-card-body">
                            <div class="d-flex gap-3 mb-3">
                                <div class="admin-thumb">
                                    <i class="bi bi-camera-reels"></i>
                                </div>
                                <div>
                                    <div class="admin-card-title">{{ $exercise['name'] }}</div>
                                    <div class="admin-card-text">
                                        {{ $exercise['category'] }} · {{ $exercise['subcategory'] }} · {{ $exercise['level'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="admin-tag">{{ $exercise['parent'] }}</span>
                                <span class="admin-tag">{{ $exercise['category'] }}</span>
                                <span class="admin-tag blue">{{ $exercise['subcategory'] }}</span>
                            </div>

                            <div class="admin-card-text">
                                {{ $exercise['desc'] }}
                            </div>

                            <div class="admin-card-actions">
                                <a href="{{ route('fitapp.admin.ejercicios.detalle') }}" class="admin-btn-soft">
                                    <i class="bi bi-play-circle"></i> Ver demo
                                </a>
                                <a href="{{ route('fitapp.admin.ejercicios.detalle') }}" class="admin-btn-soft">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="#" class="admin-btn-soft">
                                    <i class="bi bi-plus-circle"></i> Asignar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="admin-helper-note mt-3">
                <div class="fw-bold mb-1">Cómo lo estamos simulando</div>
                <div class="admin-mini">
                    Ahorita esto no trae lógica real. La “dinámica” está simulada con arrays y loops en Blade para que después cambies el origen a BD sin reventar el diseño.
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
