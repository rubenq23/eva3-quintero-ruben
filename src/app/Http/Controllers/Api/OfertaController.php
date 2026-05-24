<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OfertaController extends Controller
{
    // Muestra solo las ofertas activas (Perfil Candidato)
    public function index(): JsonResponse
    {
        // Cumple con el requisito de mostrar solo lo vigente
        $ofertas = Oferta::where('activa', true)->get();
        return response()->json($ofertas, 200);
    }

    // Crea una nueva oferta (Perfil Reclutador) - Cumple CE3 (Validación)
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // crea oferta y asergura que al crearla, por defecto esté activa (true)
        $oferta = Oferta::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'activa' => true
        ]);

        return response()->json([
            "mensaje" => "Oferta creada con éxito",
            "datos" => $oferta
        ], 201);
    }

    // EDITAR oferta (Perfil Reclutador)
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'activa' => 'required|boolean'
        ]);

        $oferta = Oferta::findOrFail($id);
        $oferta->update($request->all());

        return response()->json([
            "mensaje" => "Oferta actualizada con éxito",
            "datos" => $oferta
        ], 200);
    }

    // Baja lógica (Perfil Reclutador) (No borra de la base de datos)
    public function destroy($id): JsonResponse
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->update(['activa' => false]);

        return response()->json(["mensaje" => "Oferta desactivada (Baja lógica exitosa)"], 200);
    }

    // Ver postulantes por oferta (Perfil Reclutador)
    public function postulantes($id): JsonResponse
    {
        $oferta = Oferta::with('postulaciones')->findOrFail($id);

        return response()->json([
            "oferta" => $oferta->titulo,
            "postulantes" => $oferta->postulaciones
        ], 200);
    }
}
