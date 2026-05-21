@extends('layouts.fitapp-admin')

@section('title', 'Crear plan nutricional | FitCoach Admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    .select2-container{
        width:100% !important;
    }

    .select2-container--default .select2-selection--single{
        min-height:54px;
        border:1px solid transparent;
        border-radius:18px;
        background:var(--fa-soft);
        display:flex;
        align-items:center;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        color:var(--fa-dark);
        line-height:1.2;
        padding-left:14px;
        padding-right:36px;
        width:100%;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height:52px;
        right:10px;
    }

    .select2-dropdown{
        border:1px solid var(--fa-border);
        border-radius:18px;
        overflow:hidden;
        box-shadow:var(--fa-shadow-md);
        min-width:0;
        max-width:min(520px, calc(100vw - 32px));
    }

    .select2-container--open .select2-dropdown{
        width:100% !important;
    }

    .select2-search--dropdown{
        padding:10px;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field{
        border:1px solid var(--fa-border);
        border-radius:14px;
        min-height:42px;
        padding:8px 12px;
    }

    .nutrition-builder-table{
        min-width:1040px;
    }

    .nutrition-builder-table th:first-child,
    .nutrition-builder-table td:first-child{
        min-width:320px;
        width:38%;
    }

    .nutrition-builder-table input[readonly]{
        background:#fff;
        cursor:default;
    }

    .nutrition-portion-control{
        display:flex;
        align-items:center;
        gap:8px;
        min-width:190px;
    }

    .nutrition-portion-control .admin-icon-btn{
        width:34px;
        height:28px;
        min-height:28px;
        border-radius:12px;
        font-size:.9rem;
    }

    .nutrition-portion-control .input-soft{
        min-height:42px;
        text-align:center;
        min-width:92px;
        padding-left:10px;
        padding-right:10px;
        font-weight:700;
    }

    .nutrition-portion-actions{
        display:flex;
        flex-direction:column;
        gap:4px;
        flex:0 0 34px;
    }

    .nutrition-portion-unit{
        min-width:42px;
        color:var(--fa-muted);
        font-size:.82rem;
        font-weight:700;
    }
</style>
@endpush

@section('content')
@php
    $meals = [
        [
            'name' => 'Desayuno',
            'icon' => 'bi-sunrise-fill',
            'items' => [
                ['food' => '1 scoop de proteina', 'kcal' => '122', 'protein' => '27.70', 'carbs' => '.39', 'fat' => '1.25'],
                ['food' => '50 g de avena', 'kcal' => '194', 'protein' => '8.44', 'carbs' => '33.14', 'fat' => '3.45'],
                ['food' => '100 g de fresas', 'kcal' => '32', 'protein' => '.67', 'carbs' => '1.68', 'fat' => '.30'],
                ['food' => '130 g de platano', 'kcal' => '116', 'protein' => '1.42', 'carbs' => '29.69', 'fat' => '.43'],
                ['food' => '1 cucharada de miel', 'kcal' => '64', 'protein' => '.06', 'carbs' => '17.30', 'fat' => '0'],
            ],
        ],
        [
            'name' => 'Almuerzo',
            'icon' => 'bi-cup-hot-fill',
            'items' => [
                ['food' => '150 g de espagueti', 'kcal' => '235', 'protein' => '8.64', 'carbs' => '46.02', 'fat' => '1.38'],
                ['food' => '75 g de requeson', 'kcal' => '90', 'protein' => '7.45', 'carbs' => '2.32', 'fat' => '5.59'],
                ['food' => '30 g de espinacas', 'kcal' => '7', 'protein' => '.86', 'carbs' => '1.09', 'fat' => '.12'],
                ['food' => '50 g de zanahoria', 'kcal' => '20', 'protein' => '.46', 'carbs' => '4.79', 'fat' => '.12'],
                ['food' => '1 cucharada de aceite de oliva', 'kcal' => '119', 'protein' => '0', 'carbs' => '0', 'fat' => '13.50'],
            ],
        ],
        [
            'name' => 'Aperitivo',
            'icon' => 'bi-basket2-fill',
            'items' => [
                ['food' => '35 g de mamey', 'kcal' => '18', 'protein' => '.18', 'carbs' => '4.38', 'fat' => '.18'],
                ['food' => '85 g de mango', 'kcal' => '55', 'protein' => '.43', 'carbs' => '14.45', 'fat' => '.23'],
                ['food' => '10 almendras', 'kcal' => '69', 'protein' => '2.55', 'carbs' => '2.37', 'fat' => '6.08'],
            ],
        ],
        [
            'name' => 'Comida',
            'icon' => 'bi-egg-fried',
            'items' => [
                ['food' => '100 g de pechuga de pollo', 'kcal' => '195', 'protein' => '29.55', 'carbs' => '0', 'fat' => '7.72'],
                ['food' => '150 g de arroz blanco cocido', 'kcal' => '194', 'protein' => '3.99', 'carbs' => '41.85', 'fat' => '.42'],
                ['food' => '100 g de frijoles cocidos', 'kcal' => '151', 'protein' => '5.54', 'carbs' => '21.39', 'fat' => '5.15'],
                ['food' => '100 g de aguacate', 'kcal' => '160', 'protein' => '2', 'carbs' => '8.53', 'fat' => '14.66'],
            ],
        ],
        [
            'name' => 'Cena',
            'icon' => 'bi-moon-stars-fill',
            'items' => [
                ['food' => '200 g de tilapia', 'kcal' => '192', 'protein' => '40.16', 'carbs' => '0', 'fat' => '3.40'],
                ['food' => '150 g de papa cocida', 'kcal' => '120', 'protein' => '3.23', 'carbs' => '27.33', 'fat' => '.16'],
                ['food' => '100 g de pepino', 'kcal' => '15', 'protein' => '.65', 'carbs' => '3.63', 'fat' => '.11'],
            ],
        ],
    ];

    $catalogs = $catalogs ?? [
        ['name' => 'Proteinas', 'icon' => 'bi-lightning-charge-fill', 'items' => 'Pollo, tilapia, atun, huevo, whey, requeson'],
        ['name' => 'Carbohidratos', 'icon' => 'bi-bar-chart-fill', 'items' => 'Avena, arroz, papa, pasta, platano, miel'],
        ['name' => 'Frutas', 'icon' => 'bi-flower1', 'items' => 'Fresas, mango, mamey, manzana, frutos rojos'],
        ['name' => 'Verduras', 'icon' => 'bi-leaf-fill', 'items' => 'Espinaca, pepino, zanahoria, ensaladas'],
        ['name' => 'Grasas', 'icon' => 'bi-droplet-fill', 'items' => 'Aguacate, aceite de oliva, almendras, nueces'],
    ];
@endphp

<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-journal-plus me-2 text-primary-custom"></i>Nuevo plan nutricional</h1>
        <div class="admin-topbar-subtitle">Arma el plan desde cero seleccionando alimentos del catalogo y ajustando porciones.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.nutricion') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <button class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> Guardar plan</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-grid-cards mb-4">
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-fire me-1 text-primary-custom"></i>Total calorico</div>
        <div class="admin-stat-value" data-total-calories>0</div>
        <div class="admin-stat-note">Se calcula al agregar alimentos</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-lightning-charge me-1 text-primary-custom"></i>Proteinas</div>
        <div class="admin-stat-value" data-total-protein>0</div>
        <div class="admin-stat-note">gramos al dia</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-bar-chart me-1 text-primary-custom"></i>Hidratos</div>
        <div class="admin-stat-value" data-total-carbohydrates>0</div>
        <div class="admin-stat-note">gramos al dia</div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-label"><i class="bi bi-droplet-half me-1 text-primary-custom"></i>Grasas</div>
        <div class="admin-stat-value" data-total-fat>0</div>
        <div class="admin-stat-note">gramos al dia</div>
    </div>
</div>

<div class="routine-builder-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon">
                        <i class="bi bi-card-heading"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Datos del plan</h2>
                        <div class="admin-mini">Identifica el plan, usuario, fecha y objetivo nutricional.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-circle"></i>Nombre</label>
                        <input type="text" class="form-control input-soft" placeholder="Ej. Adrian 2168 Kcal">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-event"></i>Fecha</label>
                        <input type="text" class="form-control input-soft" placeholder="18-04-2026">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-droplet"></i>Agua diaria</label>
                        <input type="text" class="form-control input-soft" placeholder="3 litros">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-bullseye"></i>Objetivo</label>
                        <select class="form-select input-soft">
                            <option selected>Masa muscular</option>
                            <option>Definicion</option>
                            <option>Recomposicion</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-egg-fried"></i>Comidas</label>
                        <select class="form-select input-soft">
                            <option>4 comidas</option>
                            <option selected>5 comidas</option>
                            <option>6 comidas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-toggle-on"></i>Estado</label>
                        <select class="form-select input-soft">
                            <option>Borrador</option>
                            <option selected>Activo</option>
                            <option>Plantilla</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @foreach($meals as $meal)
            <div class="admin-form-card">
                <div class="admin-form-card-head">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="admin-section-heading">
                            <div class="admin-section-icon {{ $loop->odd ? 'accent' : 'success' }}">
                                <i class="bi {{ $meal['icon'] }}"></i>
                            </div>
                            <div>
                                <h2 class="admin-panel-title mb-1">{{ $meal['name'] }}</h2>
                                <div class="admin-mini">Alimentos, calorias y macronutrientes de esta comida.</div>
                            </div>
                        </div>
                        <button class="admin-btn-soft"><i class="bi bi-plus-circle"></i> Agregar alimento</button>
                    </div>
                </div>

                <div class="admin-form-card-body">
                    <div class="admin-table-wrap">
                        <table class="admin-table nutrition-builder-table">
                            <thead>
                                <tr>
                                    <th>Alimento</th>
                                    <th>Cantidad</th>
                                    <th>Calorias</th>
                                    <th>Proteinas</th>
                                    <th>Hidratos</th>
                                    <th>Grasas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-food-row>
                                    <td>
                                        <select class="form-select input-soft food-select2" data-food-select>
                                            <option value="">Selecciona alimento</option>
                                            @foreach($catalogs as $catalog)
                                                <optgroup label="{{ $catalog['name'] }}">
                                                    @foreach($catalog['foods'] ?? [] as $food)
                                                        <option
                                                            value="{{ $food['id'] }}"
                                                            data-unit="{{ $food['base_unit'] }}"
                                                            data-quantity="{{ $food['base_quantity'] }}"
                                                            data-calories="{{ $food['calories'] }}"
                                                            data-protein="{{ $food['protein'] }}"
                                                            data-carbohydrates="{{ $food['carbohydrates'] }}"
                                                            data-fat="{{ $food['fat'] }}"
                                                        >
                                                            {{ $food['name'] }} - {{ $food['base_unit'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <div class="admin-mini mt-1" data-food-unit>Base: selecciona alimento</div>
                                    </td>
                                    <td>
                                        <div class="nutrition-portion-control">
                                            <input class="form-control input-soft" data-food-quantity placeholder="0" inputmode="decimal">
                                            <div class="nutrition-portion-actions">
                                                <button type="button" class="admin-icon-btn" data-portion-plus><i class="bi bi-plus"></i></button>
                                                <button type="button" class="admin-icon-btn" data-portion-minus><i class="bi bi-dash"></i></button>
                                            </div>
                                            <span class="nutrition-portion-unit" data-food-quantity-unit></span>
                                        </div>
                                    </td>
                                    <td><input class="form-control input-soft" data-food-calories placeholder="0" readonly></td>
                                    <td><input class="form-control input-soft" data-food-protein placeholder="0" readonly></td>
                                    <td><input class="form-control input-soft" data-food-carbohydrates placeholder="0" readonly></td>
                                    <td><input class="form-control input-soft" data-food-fat placeholder="0" readonly></td>
                                    <td><button class="admin-icon-btn"><i class="bi bi-plus"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon warn">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Catalogo de alimentos</h2>
                        <div class="admin-mini">Base sugerida para armar planes rapido.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-search mb-3">
                    <input type="text" class="form-control input-soft" placeholder="Buscar alimento...">
                </div>

                <div class="admin-list">
                    @foreach($catalogs as $catalog)
                        <div class="admin-list-item">
                            <div class="admin-list-row align-items-start">
                                <div class="admin-section-icon {{ $loop->odd ? 'success' : '' }}" style="width:38px;height:38px;border-radius:14px;font-size:1rem;">
                                    <i class="bi {{ $catalog['icon'] }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $catalog['name'] }}</div>
                                    <div class="small text-muted">{{ $catalog['items'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success">
                        <i class="bi bi-calculator-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Resumen diario</h2>
                        <div class="admin-mini">Totales que verá el coach antes de asignar.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-fire text-primary-custom mb-2"></i>
                        <div class="value" data-summary-calories>0</div>
                        <div class="label">Kcal</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-droplet text-primary-custom mb-2"></i>
                        <div class="value">3L</div>
                        <div class="label">Agua</div>
                    </div>
                </div>

                <div class="nutrition-summary-item">
                    <span><i class="bi bi-lightning-charge me-1 text-primary-custom"></i>Proteinas</span>
                    <strong data-summary-protein>0 g</strong>
                </div>
                <div class="nutrition-summary-item">
                    <span><i class="bi bi-bar-chart me-1 text-primary-custom"></i>Hidratos</span>
                    <strong data-summary-carbohydrates>0 g</strong>
                </div>
                <div class="nutrition-summary-item">
                    <span><i class="bi bi-droplet-half me-1 text-primary-custom"></i>Grasas</span>
                    <strong data-summary-fat>0 g</strong>
                </div>

                <div class="soft-divider my-3"></div>

                <button class="btn btn-primary-custom w-100 mb-2"><i class="bi bi-person-check me-1"></i> Guardar y asignar</button>
                <a href="{{ route('fitapp.plan') }}" class="btn btn-soft-custom w-100"><i class="bi bi-phone me-1"></i> Vista usuario</a>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1 text-primary-custom"></i>Como conviene armarlo</div>
            <div class="admin-mini">
                Si, lo ideal es tener catalogos por grupo: proteinas, carbohidratos, frutas, verduras, grasas y extras. Cada alimento guarda macros por porcion; el plan solo usa porciones y calcula totales.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const formatNumber = (value, decimals = 2) => {
            const number = Number.parseFloat(value || 0);
            return Number.isInteger(number) ? String(number) : number.toFixed(decimals);
        };

        const getPortionUnit = (baseUnit) => (baseUnit || 'porcion').replace(/^[\d.,]+\s*/, '');

        const getPortionStep = (baseUnit) => {
            const unit = (baseUnit || '').toLowerCase();

            if (unit.includes('g') || unit.includes('ml')) {
                return 10;
            }

            return 1;
        };

        const getSelectedFood = (row) => {
            const select = row.querySelector('[data-food-select]');
            return select?.options[select.selectedIndex] || null;
        };

        const recalculateFoodRow = (row) => {
            const selected = getSelectedFood(row);
            const quantityInput = row.querySelector('[data-food-quantity]');

            if (!selected || !selected.value || !quantityInput) {
                return;
            }

            const baseQuantity = Number.parseFloat(selected.getAttribute('data-quantity') || 1) || 1;
            const quantity = Number.parseFloat(quantityInput.value || 0);
            const factor = quantity > 0 ? quantity / baseQuantity : 0;

            row.querySelector('[data-food-calories]').value = formatNumber((selected.getAttribute('data-calories') || 0) * factor, 0);
            row.querySelector('[data-food-protein]').value = formatNumber((selected.getAttribute('data-protein') || 0) * factor);
            row.querySelector('[data-food-carbohydrates]').value = formatNumber((selected.getAttribute('data-carbohydrates') || 0) * factor);
            row.querySelector('[data-food-fat]').value = formatNumber((selected.getAttribute('data-fat') || 0) * factor);

            updateTotals();
        };

        const updateTotals = () => {
            const totals = { calories: 0, protein: 0, carbohydrates: 0, fat: 0 };

            document.querySelectorAll('[data-food-row]').forEach((row) => {
                totals.calories += Number.parseFloat(row.querySelector('[data-food-calories]')?.value || 0);
                totals.protein += Number.parseFloat(row.querySelector('[data-food-protein]')?.value || 0);
                totals.carbohydrates += Number.parseFloat(row.querySelector('[data-food-carbohydrates]')?.value || 0);
                totals.fat += Number.parseFloat(row.querySelector('[data-food-fat]')?.value || 0);
            });

            document.querySelector('[data-total-calories]')?.replaceChildren(formatNumber(totals.calories, 0));
            document.querySelector('[data-total-protein]')?.replaceChildren(formatNumber(totals.protein));
            document.querySelector('[data-total-carbohydrates]')?.replaceChildren(formatNumber(totals.carbohydrates));
            document.querySelector('[data-total-fat]')?.replaceChildren(formatNumber(totals.fat));
            document.querySelector('[data-summary-calories]')?.replaceChildren(formatNumber(totals.calories, 0));
            document.querySelector('[data-summary-protein]')?.replaceChildren(`${formatNumber(totals.protein)} g`);
            document.querySelector('[data-summary-carbohydrates]')?.replaceChildren(`${formatNumber(totals.carbohydrates)} g`);
            document.querySelector('[data-summary-fat]')?.replaceChildren(`${formatNumber(totals.fat)} g`);
        };

        if (window.jQuery && jQuery.fn.select2) {
            jQuery('.food-select2').each(function () {
                jQuery(this).select2({
                    placeholder: 'Buscar alimento...',
                    width: 'resolve',
                    dropdownAutoWidth: false,
                    dropdownParent: jQuery(this).closest('.admin-form-card'),
                });
            });
        }

        const fillFoodRow = (select) => {
            const row = select.closest('[data-food-row]');
            const selected = select.options[select.selectedIndex];

            if (!row || !selected || !selected.value) {
                if (row) {
                    row.querySelector('[data-food-quantity]').value = '';
                    row.querySelector('[data-food-quantity-unit]').textContent = '';
                    row.querySelector('[data-food-calories]').value = '';
                    row.querySelector('[data-food-protein]').value = '';
                    row.querySelector('[data-food-carbohydrates]').value = '';
                    row.querySelector('[data-food-fat]').value = '';
                    row.querySelector('[data-food-unit]').textContent = 'Base: selecciona alimento';
                }
                updateTotals();
                return;
            }

            const baseUnit = selected.getAttribute('data-unit') || 'porcion';
            const baseQuantity = selected.getAttribute('data-quantity') || 1;
            const portionUnit = getPortionUnit(baseUnit);

            row.querySelector('[data-food-quantity]').value = formatNumber(baseQuantity);
            row.querySelector('[data-food-quantity-unit]').textContent = portionUnit;

            const unit = row.querySelector('[data-food-unit]');
            if (unit) {
                unit.textContent = `Base: ${baseUnit} = ${formatNumber(selected.getAttribute('data-calories'), 0)} kcal | P ${formatNumber(selected.getAttribute('data-protein'))}g | H ${formatNumber(selected.getAttribute('data-carbohydrates'))}g | G ${formatNumber(selected.getAttribute('data-fat'))}g`;
            }

            recalculateFoodRow(row);
        };

        document.querySelectorAll('[data-food-select]').forEach((select) => {
            select.addEventListener('change', () => fillFoodRow(select));
        });

        if (window.jQuery) {
            jQuery(document).on('select2:select change', '[data-food-select]', function () {
                fillFoodRow(this);
            });
        }

        document.querySelectorAll('[data-food-row]').forEach((row) => {
            row.querySelector('[data-food-quantity]')?.addEventListener('input', () => recalculateFoodRow(row));

            row.querySelector('[data-portion-minus]')?.addEventListener('click', () => {
                const selected = getSelectedFood(row);
                const input = row.querySelector('[data-food-quantity]');

                if (!selected || !selected.value || !input) {
                    return;
                }

                const step = getPortionStep(selected.getAttribute('data-unit'));
                const current = Number.parseFloat(input.value || 0);
                input.value = formatNumber(Math.max(0, current - step));
                recalculateFoodRow(row);
            });

            row.querySelector('[data-portion-plus]')?.addEventListener('click', () => {
                const selected = getSelectedFood(row);
                const input = row.querySelector('[data-food-quantity]');

                if (!selected || !selected.value || !input) {
                    return;
                }

                const step = getPortionStep(selected.getAttribute('data-unit'));
                const current = Number.parseFloat(input.value || 0);
                input.value = formatNumber(current + step);
                recalculateFoodRow(row);
            });
        });

        updateTotals();
    });
</script>
@endpush
