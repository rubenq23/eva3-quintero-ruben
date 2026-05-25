<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactoSolicitado;
use App\Models\Persona;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function listarContactos(Request $request): JsonResponse
    {
        $query = ContactoSolicitado::with(['empresa', 'persona']);

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        return response()->json(["success" => true, "data" => $query->get()], 200);
    }

    public function crearContacto(Request $request): JsonResponse
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'persona_id' => 'required|exists:personas,id',
            'notes_admin' => 'nullable|string'
        ]);

        $existeActivo = ContactoSolicitado::where('empresa_id', $request->empresa_id)
            ->where('persona_id', $request->persona_id)
            ->whereNotIn('estado', ['proceso-cerrado'])
            ->exists();

        if ($existeActivo) {
            return response()->json([
                "success" => false,
                "message" => "Ya existe una solicitud activa entre esta empresa y talento"
            ], 409);
        }

        $contacto = ContactoSolicitado::create($request->all());
        return response()->json(["success" => true, "data" => $contacto], 201);
    }

    public function actualizarEstado(Request $request, $id): JsonResponse
    {
        $contacto = ContactoSolicitado::find($id);
        if (!$contacto) {
            return response()->json(["success" => false, "message" => "Contacto no encontrado."], 404);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,contactado,entrevista,seleccionado,no-seleccionado,proceso-cerrado',
            'notas_admin' => 'nullable|string'
        ]);

        $nuevoEstado = $request->estado;
        $updates = ['estado' => $nuevoEstado];

        if ($request->has('notas_admin')) {
            $updates['notas_admin'] = $request->notas_admin;
        }

        // Registro automático de fechas según el estado
        $fechaActual = date('Y-m-d');
        if ($nuevoEstado === 'contactado') $updates['fecha_contacto'] = $fechaActual;
        if ($nuevoEstado === 'entrevista') $updates['fecha_entrevista'] = $fechaActual;
        if (in_array($nuevoEstado, ['seleccionado', 'no-seleccionado'])) $updates['fecha_resultado'] = $fechaActual;

        $contacto->update($updates);

        return response()->json(["success" => true, "data" => $contacto], 200);
    }

    public function estadisticas(): JsonResponse
    {
        $data = [
            "total_personas" => Persona::count(),
            "personas_validadas" => Persona::where('validado', true)->count(),
            "total_empresas" => Empresa::count(),
            "empresas_validadas" => Empresa::where('validado', true)->count(),
            "contactos_pendientes" => ContactoSolicitado::where('estado', 'pendiente')->count(),
            "contactos_en_proceso" => ContactoSolicitado::whereIn('estado', ['contactado', 'entrevista'])->count(),
            "contactos_exitosos" => ContactoSolicitado::where('estado', 'seleccionado')->count(),
        ];

        return response()->json(["success" => true, "data" => $data], 200);
    }
}
