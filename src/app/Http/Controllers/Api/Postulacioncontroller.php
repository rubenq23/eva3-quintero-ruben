<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostulacionController extends Controller
{
    /**
     * Permite registrar una nueva postulación (Perfil Candidato)
     *  validación de existencia de oferta
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "oferta_id" => "required|exists:ofertas,id",
            "nombre_candidato" => "required|string|max:255",
            "email_candidato" => "required|email",
        ]);

        $postulacion = Postulacion::create([
            'oferta_id' => $request->oferta_id,
            'nombre_candidato' => $request->nombre_candidato,
            'email_candidato' => $request->email_candidato,
            'estado' => 'Postulando'
        ]);

        return response()->json([
            "mensaje" => "Postulación recibida con éxito",
            "datos" => $postulacion
        ], 201);
    }

    /**
     * Ver detalle de postulación (Perfil Candidato)
     * Ver el estado actual de su postulación y los comentarios registrados"
     *
     */
    public function show($id): JsonResponse
    {
        try {
            // Busca la postulación e incluimos sus comentarios
            // Se usa el nombre de la relación definido en el Modelo Postulacion
            $postulacion = Postulacion::with('comentarios')->findOrFail($id);

            return response()->json([
                "mensaje" => "Detalle de la postulación recuperado con éxito",
                "datos" => $postulacion
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "error" => "No se encontró la postulación solicitada"
            ], 404);
        }
    }

    /**
     * Cambia estado y agrega comentario (Perfil Reclutador)
     * Gestiona datos garantizando integridad mediante Transacciones
     */
    public function actualizarEstado(Request $request, $id): JsonResponse
    {
        $request->validate([
            'estado' => 'required|in:Postulando,Revisando,Entrevista Psicológica,Entrevista Personal,Seleccionado,Descartado',
            'comentario' => 'required|string'
        ]);

        try {
            // La transacción asegura que se guarden ambos datos (estado y comentario) o ninguno
            return DB::transaction(function () use ($request, $id) {
                $postulacion = Postulacion::findOrFail($id);

                // Actualiza el estado de la postulación
                $postulacion->update(['estado' => $request->estado]);

                // Crea el comentario obligatorio asociado al cambio de estado
                $postulacion->comentarios()->create([
                    'texto' => $request->comentario
                ]);

                return response()->json(["mensaje" => "Estado actualizado correctamente"], 200);
            });
        } catch (\Exception $e) {
            return response()->json([
                "error" => "No se pudo actualizar el proceso",
                "detalle" => $e->getMessage()
            ], 500);
        }
    }
}
