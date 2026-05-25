<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PersonaController extends Controller
{
    // Listar perfiles aplicando CV Ciego
    public function index(Request $request): JsonResponse
    {
        $query = Persona::where('activo', true);

        if ($request->has('validado')) {
            $query->where('validado', $request->boolean('validado'));
        }

        if ($request->has('nivel_educacional')) {
            $query->where('nivel_educacional', $request->nivel_educacional);
        }

        $personas = $query->get()->map(function ($persona) {
            return [
                "id" => $persona->id,
                "codigo_talento" => $persona->codigo_talento,
                "resumen" => $persona->resumen,
                "nivel_educacional" => $persona->nivel_educacional,
                "titulo_carrera" => $persona->titulo_carrera,
                "anio_egreso" => $persona->anio_egreso,
                "anios_experiencia" => $persona->anios_experiencia,
                "areas_experiencia" => $persona->areas_experiencia,
                "competencias" => $persona->competencias,
                "rango_renta" => $persona->rango_renta,
                "tipo_jornada" => $persona->tipo_jornada,
                "modalidad" => $persona->modalidad,
                "persona_discapacidad" => $persona->persona_discapacidad
            ];
        ]);

        return response()->json(["success" => true, "data" => $personas], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "email" => "required|email|unique:personas,email",
            "telefono" => "nullable|string|max:15",
            "resumen" => "nullable|string",
            "nivel_educacional" => "nullable|in:basica,media,tecnica,universitaria,postgrado",
            "titulo_carrera" => "nullable|string",
            "anio_egreso" => "nullable|integer|between:1950," . date('Y'),
            "anios_experiencia" => "nullable|integer|min:0",
            "areas_experiencia" => "nullable|array",
            "competencias" => "nullable|array",
            "rango_renta" => "nullable|string",
            "tipo_jornada" => "nullable|in:completa,part-time,por-horas",
            "modalidad" => "nullable|in:presencial,remoto,hibrido",
            "cursos" => "nullable|array",
            "idiomas" => "nullable|array",
            "persona_discapacidad" => "nullable|boolean"
        ]);

        $persona = Persona::create($validated);

        return response()->json(["success" => true, "data" => $persona], 201);
    }

    public function show($id): JsonResponse
    {
        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(["success" => false, "message" => "Persona no encontrada."], 404);
        }
        return response()->json(["success" => true, "data" => $persona], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(["success" => false, "message" => "Persona no encontrada."], 404);
        }

        $persona->update($request->all());
        return response()->json(["success" => true, "data" => $persona], 200);
    }

    public function destroy($id): JsonResponse
    {
        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(["success" => false, "message" => "Persona no encontrada."], 404);
        }

        $persona->update(['activo' => false]);
        return response()->json(["success" => true, "data" => ["message" => "Persona desactivada exitosamente."]], 200);
    }

    public function validar($id): JsonResponse
    {
        $persona = Persona::find($id);
        if (!$persona) {
            return response()->json(["success" => false, "message" => "Persona no encontrada."], 404);
        }

        $persona->update(['validado' => true]);
        return response()->json(["success" => true, "data" => $persona], 200);
    }
}
