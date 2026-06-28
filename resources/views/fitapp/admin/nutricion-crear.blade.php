@extends('layouts.fitapp-admin')

@section('title', 'Crear plan nutricional | FitCoach Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<style>
    .nutrition-food-select + .select2-container{
        width:100% !important;
    }

    .nutrition-food-select + .select2-container .select2-selection--single{
        min-height:52px;
        border:0;
        border-radius:16px;
        background:#eaf1f5;
        display:flex;
        align-items:center;
        padding:10px 14px;
    }

    .nutrition-food-select + .select2-container .select2-selection__rendered{
        color:#15232c;
        line-height:1.25;
        padding-left:0;
        padding-right:26px;
    }

    .nutrition-food-select + .select2-container .select2-selection__arrow{
        height:52px;
        right:10px;
    }

    .nutrition-food-select + .select2-container .select2-selection__clear{
        margin-right:18px;
    }

    .nutrition-meal-actions{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        justify-content:flex-end;
    }

    .nutrition-item-actions{
        width:1%;
        white-space:nowrap;
    }

    .nutrition-remove-item{
        width:42px;
        height:42px;
        border-radius:14px;
        padding:0;
        display:inline-grid;
        place-items:center;
    }
</style>
@endpush

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
                    $oldItems = collect(old("meals.$mealIndex.items", []));
                    $itemCount = max(4, $mealItems->count(), $oldItems->count());
                @endphp
                <div class="admin-form-card nutrition-meal-card" data-meal-index="{{ $mealIndex }}">
                    <div class="admin-form-card-head">
                        <div>
                            <h2 class="admin-panel-title mb-1">{{ $mealName }}</h2>
                            <div class="admin-mini">Agrega los alimentos necesarios para esta comida.</div>
                        </div>
                        <div class="nutrition-meal-actions">
                            <button type="button" class="admin-btn-soft" data-add-food-row><i class="bi bi-plus-circle"></i> Agregar alimento</button>
                        </div>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody data-food-rows data-next-index="{{ $itemCount }}">
                                    @for ($itemIndex = 0; $itemIndex < $itemCount; $itemIndex++)
                                        @php
                                            $item = $mealItems->get($itemIndex);
                                            $selectedFoodId = old("meals.$mealIndex.items.$itemIndex.food_id", $item?->food_id);
                                            $quantity = old("meals.$mealIndex.items.$itemIndex.quantity", $item?->quantity);
                                        @endphp
                                        <tr>
                                            <td>
                                                <select name="meals[{{ $mealIndex }}][items][{{ $itemIndex }}][food_id]" class="form-select input-soft nutrition-food-select" data-placeholder="Selecciona alimento">
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
                                            <td class="nutrition-item-actions">
                                                <button type="button" class="admin-btn-soft nutrition-remove-item" data-remove-food-row aria-label="Quitar alimento"><i class="bi bi-trash3"></i></button>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <template data-food-row-template>
                            <tr>
                                <td>
                                    <select name="meals[{{ $mealIndex }}][items][__ITEM_INDEX__][food_id]" class="form-select input-soft nutrition-food-select" data-placeholder="Selecciona alimento">
                                        <option value="">Selecciona alimento</option>
                                        @foreach($catalogs as $catalog)
                                            <optgroup label="{{ $catalog['name'] }}">
                                                @foreach($catalog['foods'] ?? [] as $food)
                                                    @php $isExcluded = $selectedExcludedIds->contains((int) $food['id']); @endphp
                                                    <option value="{{ $food['id'] }}" @disabled($isExcluded)>
                                                        {{ $food['name'] }} - {{ $food['base_unit'] }}{{ $isExcluded ? ' | No incluir' : '' }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.01" name="meals[{{ $mealIndex }}][items][__ITEM_INDEX__][quantity]" class="form-control input-soft" placeholder="100"></td>
                                <td><span class="admin-mini">Usa la unidad indicada en el alimento.</span></td>
                                <td class="nutrition-item-actions">
                                    <button type="button" class="admin-btn-soft nutrition-remove-item" data-remove-food-row aria-label="Quitar alimento"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                        </template>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const initFoodSelect = (select) => {
            if (!window.jQuery || !jQuery.fn.select2 || select.dataset.select2Ready === '1') {
                return;
            }

            jQuery(select).select2({
                allowClear: true,
                placeholder: select.dataset.placeholder || 'Selecciona alimento',
                width: '100%',
            });

            select.dataset.select2Ready = '1';
        };

        const refreshRemoveState = (card) => {
            const rows = card.querySelectorAll('[data-food-rows] tr');
            rows.forEach((row) => {
                const removeButton = row.querySelector('[data-remove-food-row]');
                removeButton?.toggleAttribute('disabled', rows.length <= 1);
            });
        };

        document.querySelectorAll('.nutrition-food-select').forEach(initFoodSelect);
        document.querySelectorAll('.nutrition-meal-card').forEach(refreshRemoveState);

        document.querySelectorAll('[data-add-food-row]').forEach((button) => {
            button.addEventListener('click', () => {
                const card = button.closest('.nutrition-meal-card');
                const rows = card?.querySelector('[data-food-rows]');
                const template = card?.querySelector('[data-food-row-template]');

                if (!card || !rows || !template) {
                    return;
                }

                const itemIndex = Number(rows.dataset.nextIndex || rows.querySelectorAll('tr').length);
                rows.dataset.nextIndex = itemIndex + 1;

                const wrapper = document.createElement('tbody');
                wrapper.innerHTML = template.innerHTML.replaceAll('__ITEM_INDEX__', String(itemIndex)).trim();
                const row = wrapper.firstElementChild;
                rows.appendChild(row);

                row.querySelectorAll('.nutrition-food-select').forEach(initFoodSelect);
                refreshRemoveState(card);
            });
        });

        document.addEventListener('click', (event) => {
            const removeButton = event.target.closest('[data-remove-food-row]');

            if (!removeButton) {
                return;
            }

            const card = removeButton.closest('.nutrition-meal-card');
            const row = removeButton.closest('tr');
            const rows = card?.querySelectorAll('[data-food-rows] tr') || [];

            if (!card || !row) {
                return;
            }

            if (rows.length <= 1) {
                const select = row.querySelector('.nutrition-food-select');
                const quantity = row.querySelector('input[type="number"]');

                if (select && window.jQuery && jQuery.fn.select2) {
                    jQuery(select).val(null).trigger('change');
                } else if (select) {
                    select.value = '';
                }

                if (quantity) {
                    quantity.value = '';
                }

                return;
            }

            const select = row.querySelector('.nutrition-food-select');

            if (select && window.jQuery && jQuery.fn.select2 && select.dataset.select2Ready === '1') {
                jQuery(select).select2('destroy');
            }

            row.remove();
            refreshRemoveState(card);
        });
    });
</script>
@endpush
