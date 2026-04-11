<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('fitapp')->name('fitapp.')->group(function () {

    Route::view('/splash', 'fitapp.splash')->name('splash');
    Route::view('/auth', 'fitapp.auth')->name('auth');

    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::view('/bienvenida', 'fitapp.onboarding.welcome')->name('welcome');
        Route::view('/objetivo', 'fitapp.onboarding.goal')->name('goal');
        Route::view('/servicio', 'fitapp.onboarding.service')->name('service');
        Route::view('/entrenamiento', 'fitapp.onboarding.training')->name('training');
        Route::view('/nutricion', 'fitapp.onboarding.nutrition')->name('nutrition');
        Route::view('/cita', 'fitapp.onboarding.appointment')->name('appointment');
    });

    Route::view('/dashboard', 'fitapp.dashboard')->name('dashboard');
    Route::view('/rutina', 'fitapp.rutina')->name('rutina');
    Route::view('/rutina-dia', 'fitapp.rutina-dia')->name('rutina-dia');
    Route::view('/nutricion-diaria', 'fitapp.nutricion')->name('nutricion');

    Route::view('/plan-alimentario', 'fitapp.plan-alimentario')->name('plan');
    Route::view('/recetas', 'fitapp.recetas')->name('recetas');
    Route::view('/progreso', 'fitapp.progreso')->name('progreso');
    Route::view('/perfil', 'fitapp.perfil')->name('perfil');

});

    Route::prefix('admin')->name('fitapp.admin.')->group(function () {
        Route::view('/dashboard', 'fitapp.admin.dashboard')->name('dashboard');
        Route::view('/citas', 'fitapp.admin.citas')->name('citas');
        Route::view('/usuarios', 'fitapp.admin.usuarios')->name('usuarios');
        Route::view('/rutinas', 'fitapp.admin.rutinas')->name('rutinas');
        Route::view('/ejercicios', 'fitapp.admin.ejercicios')->name('ejercicios');
        Route::view('/ejercicios/crear', 'fitapp.admin.ejercicios-crear')->name('ejercicios.crear');
        Route::view('/ejercicios/detalle', 'fitapp.admin.ejercicio-detalle')->name('ejercicios.detalle');
        Route::view('/evidencias', 'fitapp.admin.evidencias')->name('evidencias');
        Route::view('/nutricion', 'fitapp.admin.nutricion')->name('nutricion');
        Route::view('/pagos', 'fitapp.admin.pagos')->name('pagos');
        Route::view('/configuracion', 'fitapp.admin.configuracion')->name('configuracion');
    });
