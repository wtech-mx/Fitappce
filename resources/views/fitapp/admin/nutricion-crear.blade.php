@extends('layouts.fitapp-admin')

@section('title', 'Crear plan nutricional | FitCoach Admin')

@section('content')
@php
    $mode = $mode ?? 'create';
    $plan = $plan ?? null;
    $mealNames = ['Desayuno', 'Colacion', 'Comida', 'Snack', 'Cena'];
    $planMeals = $plan?->meals?->values() ?? collect();
    $mealCount = max(count($mealNames), $planMeals->count());
    $selectedExcludedIds = collect($selectedUser?->excluded_food_ids ?? [])->map(fn ($id) => (int) $id);
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-journal-plus me-2 text-primary-custom"></i>{{ $mode === 'edit' ? 'Editar plan nutricional' : 'Nuevo plan nutricional' }}</h1>
        <div class="admin-topbar-subtitle">{{ $mode === 'edit' ? 'Modifica comidas, alimentos y macros del plan.' : 'Asigna comidas y alimentos reales a un cliente.' }}</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ $mode === 'edit' && $plan ? route('fitapp.admin.nutricion.show', $plan) : route('fitapp.admin.nutricion') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <button type="submit" form="nutritionPlanForm" class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> Guardar plan</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ $mode === 'edit' && $plan ? route('fitapp.admin.nutricion.update', $plan) : route('fitapp.admin.nutricion.store') }}" id="nutritionPlanForm">
    @csrf
    @if($mode === 'edit')
        @method('PUT')
    @endif

    <div class="admin-grid-cards mb-4">
        <div class="admin-stat-card">
            <div class="admin-stat-label"><i class="bi bi-fire me-1 text-primary-custom"></i>Kcal objetivo</div>
            <input type="number" step="0.01" name="target_calories" value="{{ old('target_calories', $plan?->target_calories) }}" class="form-control input-soft mt-2" placeholder="2100">
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label"><i class="bi bi-lightning-charge me-1 text-primary-custom"></i>Proteina g</div>
            <input type="number" step="0.01" name="target_protein" value="{{ old('target_protein', $plan?->target_protein) }}" class="form-control input-soft mt-2" placeholder="160">
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label"><i class="bi bi-bar-chart me-1 text-primary-custom"></i>Carbs g</div>
            <input type="number" step="0.01" name="target_carbohydrates" value="{{ old('target_carbohydrates', $plan?->target_carbohydrates) }}" class="form-control input-soft mt-2" placeholder="230">
        </div>
        <div class="admin-stat-card">
            <div class="admin-stat-label"><i class="bi bi-droplet-half me-1 text-primary-custom"></i>Grasas g</div>
            <input type="number" step="0.01" name="target_fat" value="{{ old('target_fat', $plan?->target_fat) }}" class="form-control input-soft mt-2" placeholder="60">
        </div>
    </div>

    <div class="routine-builder-layout">
        <div class="admin-section-stack">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Datos del plan</h2>
                    <div class="admin-mini">Cliente, fecha, objetivo y estado.</div>
                </div>
                <div class="admin-form-card-body">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-circle"></i>Cliente</label>
                            <select class="form-select input-soft" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('user_id', $plan?->user_id ?? $selectedUser?->id) == $user->id)>{{ $user->name }} - {{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-card-heading"></i>Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $plan?->name ?? ($selectedUser ? 'Plan de '.$selectedUser->name : '')) }}" class="form-control input-soft" placeholder="Plan 2100 kcal" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-event"></i>Fecha</label>
                            <input type="date" name="plan_date" value="{{ old('plan_date', $plan?->plan_date ?? now()->toDateString()) }}" class="form-control input-soft">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-bullseye"></i>Objetivo</label>
                            <input type="text" name="goal" value="{{ old('goal', $plan?->goal ?? $selectedUser?->goal) }}" class="form-control input-soft" placeholder="Masa muscular">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-egg-fried"></i>Comidas por dia</label>
                            <input type="number" name="meals_per_day" value="{{ old('meals_per_day', $plan?->meals_per_day ?? ($selectedUser?->meals_per_day ?: 5)) }}" class="form-control input-soft" min="1" max="8" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-droplet"></i>Agua diaria</label>
                            <input type="text" name="daily_water" value="{{ old('daily_water', $plan?->daily_water ?? '3 litros') }}" class="form-control input-soft" placeholder="3 litros">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-toggle-on"></i>Estado</label>
                            <select class="form-select input-soft" name="status" required>
                                <option value="draft" @selected(old('status', $plan?->status) === 'draft')>Borrador</option>
                                <option value="active" @selected(old('status', $plan?->status ?? 'active') === 'active')>Activo</option>
                                <option value="archived" @selected(old('status', $plan?->status) === 'archived')>Archivado</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold admin-label-icon"><i class="bi bi-card-text"></i>Notas</label>
                            <textarea name="notes" class="form-control input-soft py-3" rows="3" placeholder="Indicaciones generales del plan.">{{ old('notes', $plan?->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @for ($mealIndex = 0; $mealIndex < $mealCount; $mealIndex++)
                @php
                    $meal = $planMeals->get($mealIndex);
                    $mealName = old("meals.$mealIndex.name", $meal?->name ?? ($mealNames[$mealIndex] ?? 'Comida '.($mealIndex + 1)));
                    $mealItems = $meal?->items?->values() ?? collect();
                    $itemCount = max(4, $mealItems->count());
                @endphp
                <div class="admin-form-card">
                    <div class="admin-form-card-head">
                        <h2 class="admin-panel-title mb-1">{{ $mealName }}</h2>
                        <div class="admin-mini">Selecciona hasta 4 alimentos para esta comida.</div>
                    </div>
                    <div class="admin-form-card-body">
                        <input type="hidden" name="meals[{{ $mealIndex }}][name]" value="{{ $mealName }}">
                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Alimento</th>
                                        <th>Cantidad</th>
                                        <th>Unidad base</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($itemIndex = 0; $itemIndex < $itemCount; $itemIndex++)
                                        @php
                                            $item = $mealItems->get($itemIndex);
                                            $selectedFoodId = old("meals.$mealIndex.items.$itemIndex.food_id", $item?->food_id);
                                            $quantity = old("meals.$mealIndex.items.$itemIndex.quantity", $item?->quantity);
                                        @endphp
                                        <tr>
                                            <td>
                                                <select name="meals[{{ $mealIndex }}][items][{{ $itemIndex }}][food_id]" class="form-select input-soft">
                                                    <option value="">Selecciona alimento</option>
                                                    @foreach($catalogs as $catalog)
                                                        <optgroup label="{{ $catalog['name'] }}">
                                                            @foreach($catalog['foods'] ?? [] as $food)
                                                                @php $isExcluded = $selectedExcludedIds->contains((int) $food['id']); @endphp
                                                                <option value="{{ $food['id'] }}" @selected((string) $selectedFoodId === (string) $food['id']) @disabled($isExcluded && (string) $selectedFoodId !== (string) $food['id'])>
                                                                    {{ $food['name'] }} - {{ $food['base_unit'] }}{{ $isExcluded ? ' | No incluir' : '' }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" step="0.01" name="meals[{{ $mealIndex }}][items][{{ $itemIndex }}][quantity]" value="{{ $quantity }}" class="form-control input-soft" placeholder="100"></td>
                                            <td><span class="admin-mini">Usa la unidad indicada en el alimento.</span></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="admin-sticky-col">
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Alimentos no permitidos</h2>
                    <div class="admin-mini">Del expediente del cliente seleccionado.</div>
                </div>
                <div class="admin-form-card-body">
                    @if(! empty($excludedFoods))
                        <div class="excluded-food-list">
                            @foreach($excludedFoods as $food)
                                <div class="excluded-food-item">
                                    <div class="excluded-food-icon"><i class="bi bi-ban"></i></div>
                                    <div>
                                        <div class="fw-bold">{{ $food['name'] }}</div>
                                        <div class="admin-mini">{{ $food['category'] }} | {{ $food['base_unit'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="admin-helper-note mb-0">
                            <div class="fw-bold mb-1">Sin restricciones cargadas</div>
                            <div class="admin-mini">Los alimentos bloqueados no se podran guardar en el plan.</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <h2 class="admin-panel-title mb-1">Guardar</h2>
                    <div class="admin-mini">Si queda activo, reemplaza el plan activo anterior del cliente.</div>
                </div>
                <div class="admin-form-card-body">
                    <button type="submit" class="btn btn-primary-custom w-100 mb-2"><i class="bi bi-person-check me-1"></i> Guardar y asignar</button>
                    <a href="{{ route('fitapp.plan') }}" class="btn btn-soft-custom w-100"><i class="bi bi-phone me-1"></i> Vista usuario</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
