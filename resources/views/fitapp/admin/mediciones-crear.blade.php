@extends('layouts.fitapp-admin')

@section('title', 'Nueva medicion | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title"><i class="bi bi-rulers me-2 text-primary-custom"></i>Nueva medicion</h1>
        <div class="admin-topbar-subtitle">Captura visual de medidas por cita para crear historial y ver progreso del usuario.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones') }}" class="btn btn-soft-custom px-4"><i class="bi bi-arrow-left me-1"></i> Volver</a>
        <button class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> Guardar medicion</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-create-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Datos de la cita</h2>
                        <div class="admin-mini">Cada medicion queda ligada a una fecha de valoracion o seguimiento.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-person-circle"></i>Usuario</label>
                        <input type="text" class="form-control input-soft" value="Adrian">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-event"></i>Fecha de medicion</label>
                        <input type="text" class="form-control input-soft" value="15 de Abril 2026">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold admin-label-icon"><i class="bi bi-clipboard2-check"></i>Tipo de cita</label>
                        <select class="form-select input-soft">
                            <option selected>Valoracion inicial</option>
                            <option>Seguimiento mensual</option>
                            <option>Renovacion de plan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon warn">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Composicion corporal</h2>
                        <div class="admin-mini">Valores principales, meta y cambio esperado.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Indicador</th>
                                <th>Actual</th>
                                <th>Meta</th>
                                <th>Cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><i class="bi bi-droplet-half me-2 text-primary-custom"></i>Grasa Corporal (%)</td><td><input class="form-control input-soft" value="14.73%"></td><td><input class="form-control input-soft" value="14.00%"></td><td><input class="form-control input-soft" value="-0.73%"></td></tr>
                            <tr><td><i class="bi bi-lightning-charge me-2 text-primary-custom"></i>Masa Magra (kgs)</td><td><input class="form-control input-soft" value="55.681"></td><td><input class="form-control input-soft" value="56.158"></td><td><input class="form-control input-soft" value="0.48"></td></tr>
                            <tr><td><i class="bi bi-pie-chart me-2 text-primary-custom"></i>Masa Grasa (kgs)</td><td><input class="form-control input-soft" value="9.619"></td><td><input class="form-control input-soft" value="9.142"></td><td><input class="form-control input-soft" value="-0.48"></td></tr>
                            <tr><td><i class="bi bi-speedometer2 me-2 text-primary-custom"></i>Peso Corporal (kgs)</td><td><input class="form-control input-soft" value="65.300"></td><td><input class="form-control input-soft" value="65.300"></td><td><input class="form-control input-soft" value="0.000"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon accent">
                        <i class="bi bi-calculator-fill"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Calculos metabolicos y nutricion</h2>
                        <div class="admin-mini">Datos que ayudan a definir calorias y plan alimentario.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-fire"></i>Met Basal Harris-Benedict</label><input class="form-control input-soft" value="89.20"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-fire"></i>Met Basal K&McA Kcal</label><input class="form-control input-soft" value="1,572.72"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-speedometer"></i>Valor Calorico Total</label><input class="form-control input-soft" value="2,044.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-activity"></i>Factor AF</label><input class="form-control input-soft" value="1.3"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrow-up-circle"></i>Calorias para subir peso</label><input class="form-control input-soft" value="2,544.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-arrow-down-circle"></i>Calorias para bajar peso</label><input class="form-control input-soft" value="1,544.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-egg-fried"></i>Comidas principales</label><input class="form-control input-soft" value="5"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-cup-straw"></i>Refrigerios</label><input class="form-control input-soft" value="1 a 2"></div>
                    <div class="col-md-4"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-calendar-range"></i>Semanas para meta</label><input class="form-control input-soft" value="1.0"></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success">
                        <i class="bi bi-body-text"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Pliegues cutaneos</h2>
                        <div class="admin-mini">Campos de 1 y 2 segun tu formato actual.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Triceps 1 y 2</label><input class="form-control input-soft" value="8.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Biceps 1 y 2</label><input class="form-control input-soft" value="2.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Suprailiaco 1 y 2</label><input class="form-control input-soft" value="13.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Subescapular 1 y 2</label><input class="form-control input-soft" value="11.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Pectoral 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Abdominal 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Cuadriceps 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold admin-label-icon"><i class="bi bi-pin-angle"></i>Isquiotibial 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon danger">
                        <i class="bi bi-arrows-angle-expand"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Perimetros corporales</h2>
                        <div class="admin-mini">Captura pulgadas y centimetros cuando aplique.</div>
                    </div>
                </div>
            </div>
            <div class="admin-form-card-body">
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Perimetro</th>
                                <th>Pulgadas</th>
                                <th>Centimetros</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><i class="bi bi-person me-2 text-primary-custom"></i>Cuello</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td><i class="bi bi-activity me-2 text-primary-custom"></i>Brazo Rel.</td><td><input class="form-control input-soft" value="12.40"></td><td><input class="form-control input-soft" value="31.50"></td></tr>
                            <tr><td><i class="bi bi-lightning-charge me-2 text-primary-custom"></i>Brazo Flex.</td><td><input class="form-control input-soft" value="13.31"></td><td><input class="form-control input-soft" value="33.80"></td></tr>
                            <tr><td><i class="bi bi-arrow-left-right me-2 text-primary-custom"></i>Antebrazo</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td><i class="bi bi-person-arms-up me-2 text-primary-custom"></i>Torax</td><td><input class="form-control input-soft" value="38.19"></td><td><input class="form-control input-soft" value="97.00"></td></tr>
                            <tr><td><i class="bi bi-arrows-collapse me-2 text-primary-custom"></i>Cintura</td><td><input class="form-control input-soft" value="31.97"></td><td><input class="form-control input-soft" value="81.20"></td></tr>
                            <tr><td><i class="bi bi-record-circle me-2 text-primary-custom"></i>Abdomen</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td><i class="bi bi-universal-access me-2 text-primary-custom"></i>Cadera</td><td><input class="form-control input-soft" value="36.42"></td><td><input class="form-control input-soft" value="92.50"></td></tr>
                            <tr><td><i class="bi bi-arrow-down-up me-2 text-primary-custom"></i>Muslo</td><td><input class="form-control input-soft" value="22.09"></td><td><input class="form-control input-soft" value="56.10"></td></tr>
                            <tr><td><i class="bi bi-circle me-2 text-primary-custom"></i>Pantorrilla</td><td><input class="form-control input-soft" value="14.25"></td><td><input class="form-control input-soft" value="36.20"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <div class="admin-section-heading">
                    <div class="admin-section-icon success">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div>
                        <h2 class="admin-panel-title mb-1">Resumen rapido</h2>
                        <div class="admin-mini">Vista previa antes de guardar.</div>
                    </div>
                </div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-speedometer2 text-primary-custom mb-2"></i>
                        <div class="value">65.300</div>
                        <div class="label">Peso kg</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-droplet-half text-primary-custom mb-2"></i>
                        <div class="value">14.73%</div>
                        <div class="label">Grasa</div>
                    </div>
                </div>
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-arrows-collapse text-primary-custom mb-2"></i>
                        <div class="value">81.20</div>
                        <div class="label">Cintura cm</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <i class="bi bi-droplet text-primary-custom mb-2"></i>
                        <div class="value">3L</div>
                        <div class="label">Agua sugerida</div>
                    </div>
                </div>
                <button class="btn btn-primary-custom w-100"><i class="bi bi-check2-circle me-1"></i> Guardar medicion</button>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1 text-primary-custom"></i>Registro por cita</div>
            <div class="admin-mini">
                Cuando pasemos a backend, cada captura sera un registro historico. No se debe sobrescribir la medicion anterior; se consulta como progreso.
            </div>
        </div>
    </div>
</div>
@endsection
