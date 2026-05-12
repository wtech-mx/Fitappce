@extends('layouts.fitapp-admin')

@section('title', 'Nueva medicion | FitCoach Admin')

@section('content')
<div class="admin-topbar">
    <div>
        <h1 class="admin-topbar-title">Nueva medicion</h1>
        <div class="admin-topbar-subtitle">Captura visual de medidas por cita para crear historial y ver progreso del usuario.</div>
    </div>

    <div class="admin-topbar-actions">
        <a href="{{ route('fitapp.admin.mediciones') }}" class="btn btn-soft-custom px-4">Volver</a>
        <button class="btn btn-primary-custom px-4">Guardar medicion</button>
        <div class="admin-avatar">C</div>
    </div>
</div>

<div class="admin-create-layout">
    <div class="admin-section-stack">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Datos de la cita</h2>
                <div class="admin-mini">Cada medicion queda ligada a una fecha de valoracion o seguimiento.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Usuario</label>
                        <input type="text" class="form-control input-soft" value="Adrian">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha de medicion</label>
                        <input type="text" class="form-control input-soft" value="15 de Abril 2026">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tipo de cita</label>
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
                <h2 class="admin-panel-title mb-1">Composicion corporal</h2>
                <div class="admin-mini">Valores principales, meta y cambio esperado.</div>
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
                            <tr><td>Grasa Corporal (%)</td><td><input class="form-control input-soft" value="14.73%"></td><td><input class="form-control input-soft" value="14.00%"></td><td><input class="form-control input-soft" value="-0.73%"></td></tr>
                            <tr><td>Masa Magra (kgs)</td><td><input class="form-control input-soft" value="55.681"></td><td><input class="form-control input-soft" value="56.158"></td><td><input class="form-control input-soft" value="0.48"></td></tr>
                            <tr><td>Masa Grasa (kgs)</td><td><input class="form-control input-soft" value="9.619"></td><td><input class="form-control input-soft" value="9.142"></td><td><input class="form-control input-soft" value="-0.48"></td></tr>
                            <tr><td>Peso Corporal (kgs)</td><td><input class="form-control input-soft" value="65.300"></td><td><input class="form-control input-soft" value="65.300"></td><td><input class="form-control input-soft" value="0.000"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Calculos metabolicos y nutricion</h2>
                <div class="admin-mini">Datos que ayudan a definir calorias y plan alimentario.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label fw-bold">Met Basal Harris-Benedict</label><input class="form-control input-soft" value="89.20"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Met Basal K&McA Kcal</label><input class="form-control input-soft" value="1,572.72"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Valor Calorico Total</label><input class="form-control input-soft" value="2,044.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Factor AF</label><input class="form-control input-soft" value="1.3"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Calorias para subir peso</label><input class="form-control input-soft" value="2,544.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Calorias para bajar peso</label><input class="form-control input-soft" value="1,544.53"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Comidas principales</label><input class="form-control input-soft" value="5"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Refrigerios</label><input class="form-control input-soft" value="1 a 2"></div>
                    <div class="col-md-4"><label class="form-label fw-bold">Semanas para meta</label><input class="form-control input-soft" value="1.0"></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Pliegues cutaneos</h2>
                <div class="admin-mini">Campos de 1 y 2 segun tu formato actual.</div>
            </div>
            <div class="admin-form-card-body">
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label fw-bold">Triceps 1 y 2</label><input class="form-control input-soft" value="8.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Biceps 1 y 2</label><input class="form-control input-soft" value="2.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Suprailiaco 1 y 2</label><input class="form-control input-soft" value="13.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Subescapular 1 y 2</label><input class="form-control input-soft" value="11.50"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Pectoral 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Abdominal 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Cuadriceps 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                    <div class="col-md-3"><label class="form-label fw-bold">Isquiotibial 1 y 2</label><input class="form-control input-soft" placeholder="0.00"></div>
                </div>
            </div>
        </div>

        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Perimetros corporales</h2>
                <div class="admin-mini">Captura pulgadas y centimetros cuando aplique.</div>
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
                            <tr><td>Cuello</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td>Brazo Rel.</td><td><input class="form-control input-soft" value="12.40"></td><td><input class="form-control input-soft" value="31.50"></td></tr>
                            <tr><td>Brazo Flex.</td><td><input class="form-control input-soft" value="13.31"></td><td><input class="form-control input-soft" value="33.80"></td></tr>
                            <tr><td>Antebrazo</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td>Torax</td><td><input class="form-control input-soft" value="38.19"></td><td><input class="form-control input-soft" value="97.00"></td></tr>
                            <tr><td>Cintura</td><td><input class="form-control input-soft" value="31.97"></td><td><input class="form-control input-soft" value="81.20"></td></tr>
                            <tr><td>Abdomen</td><td><input class="form-control input-soft" value="0.00"></td><td><input class="form-control input-soft" placeholder="0.00"></td></tr>
                            <tr><td>Cadera</td><td><input class="form-control input-soft" value="36.42"></td><td><input class="form-control input-soft" value="92.50"></td></tr>
                            <tr><td>Muslo</td><td><input class="form-control input-soft" value="22.09"></td><td><input class="form-control input-soft" value="56.10"></td></tr>
                            <tr><td>Pantorrilla</td><td><input class="form-control input-soft" value="14.25"></td><td><input class="form-control input-soft" value="36.20"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-sticky-col">
        <div class="admin-form-card">
            <div class="admin-form-card-head">
                <h2 class="admin-panel-title mb-1">Resumen rapido</h2>
                <div class="admin-mini">Vista previa antes de guardar.</div>
            </div>

            <div class="admin-form-card-body">
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <div class="value">65.300</div>
                        <div class="label">Peso kg</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <div class="value">14.73%</div>
                        <div class="label">Grasa</div>
                    </div>
                </div>
                <div class="admin-stat-inline mb-3">
                    <div class="admin-stat-inline-card">
                        <div class="value">81.20</div>
                        <div class="label">Cintura cm</div>
                    </div>
                    <div class="admin-stat-inline-card">
                        <div class="value">3L</div>
                        <div class="label">Agua sugerida</div>
                    </div>
                </div>
                <button class="btn btn-primary-custom w-100">Guardar medicion</button>
            </div>
        </div>

        <div class="admin-helper-note">
            <div class="fw-bold mb-1">Registro por cita</div>
            <div class="admin-mini">
                Cuando pasemos a backend, cada captura sera un registro historico. No se debe sobrescribir la medicion anterior; se consulta como progreso.
            </div>
        </div>
    </div>
</div>
@endsection
