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
        Route::view('/resumen', 'fitapp.onboarding.summary')->name('summary');
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
