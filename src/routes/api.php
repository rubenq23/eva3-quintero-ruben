<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfertaController;
use App\Http\Controllers\Api\PostulacionController;

Route::prefix('v1')->group(function () {

    // --- RUTAS DE OFERTAS LABORALES ---

    // Obtener lista de ofertas activas para el Candidato
    Route::get('/ofertas', [OfertaController::class, 'index']);

    // Crear nueva oferta laboral (Perfil Reclutador)
    Route::post('/ofertas', [OfertaController::class, 'store']);

    // Edita información de una oferta existente (Perfil Reclutador)
    Route::put('/ofertas/{id}', [OfertaController::class, 'update']);

    //Desactiva oferta - Baja lógica (Perfil Reclutador)
    Route::delete('/ofertas/{id}', [OfertaController::class, 'destroy']);

    //Ver postulantes asociados a una oferta (Perfil Reclutador)
    Route::get('/ofertas/{id}/postulaciones', [OfertaController::class, 'postulantes']);


    //RUTAS DE POSTULACIONES

    // Postula a una oferta específica (Perfil Candidato)
    Route::post('/postulaciones', [PostulacionController::class, 'store']);

    //Ver estado y comentarios de una postulación (Perfil Candidato)
    Route::get('/postulaciones/{id}', [PostulacionController::class, 'show']);

    //Actualizar estado y registrar comentarios (Perfil Reclutador)
    Route::patch('/postulaciones/{id}/estado', [PostulacionController::class, 'actualizarEstado']);

});
