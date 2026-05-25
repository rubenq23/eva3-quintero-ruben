<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\EmpresaController;

Route::prefix('v1')->group(function () {

    // --- HEALTH CHECK ---
    Route::get('/health', function () {
        return response()->json([
            "status" => "online",
            "service" => "ProviEmplea API",
            "version" => "1.0.0",
            "timestamp" => now()->toIso8601String()
        ], 200);
    });

    // --- PERSONAS ---
    Route::get('/personas', [PersonaController::class, 'index']);
    Route::post('/personas', [PersonaController::class, 'store']);
    Route::get('/personas/{id}', [PersonaController::class, 'show']);
    Route::put('/personas/{id}', [PersonaController::class, 'update']);
    Route::delete('/personas/{id}', [PersonaController::class, 'destroy']);
    Route::patch('/personas/{id}/validar', [PersonaController::class, 'validar']);

    // --- ADMINISTRACIÓN Y SELECCIÓN ---
    Route::get('/admin/contactos', [AdminController::class, 'listarContactos']);
    Route::post('/admin/contactos', [AdminController::class, 'crearContacto']);
    Route::patch('/admin/contactos/{id}/estado', [AdminController::class, 'actualizarEstado']);
    Route::get('/admin/estadisticas', [AdminController::class, 'estadisticas']);

    // --- EMPRESAS ---
        Route::get('/empresas', [\App\Http\Controllers\Api\EmpresaController::class, 'index']);
        Route::post('/empresas', [\App\Http\Controllers\Api\EmpresaController::class, 'store']);
        Route::get('/empresas/{id}', [\App\Http\Controllers\Api\EmpresaController::class, 'show']);
        Route::put('/empresas/{id}', [\App\Http\Controllers\Api\EmpresaController::class, 'update']);
        Route::delete('/empresas/{id}', [\App\Http\Controllers\Api\EmpresaController::class, 'destroy']);
        Route::patch('/empresas/{id}/validar', [\App\Http\Controllers\Api\EmpresaController::class, 'validar']);

});
