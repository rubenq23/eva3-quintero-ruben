<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Empresa::where('activo', true);

        // Filtro opcional por tipo de empresa
        if ($request->has('tipo_empresa')) {
            $query->where('tipo_empresa', $request->tipo_empresa);
        }

        return response()->json(["success" => true, "data" => $query->get()], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            // Regex valida formato chileno estricto: 12345678-9 o 1234567-K
            'rut_empresa' => ['required', 'string', 'regex:/^\d{7,8}-[\dKk]$/', 'unique:empresas,rut_empresa'],
            'email' => 'required|email|unique:empresas,email',
            'tipo_empresa' => 'required|in:contratacion-directa,est,outsourcing',
            'contacto_nombre' => 'required|string|max:255',
            'contacto_email' => 'required|email',
            'logo_url' => 'nullable|url',
            'rubro' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string',
            'beneficios' => 'nullable|array',
            'contacto_telefono' => 'nullable|string|max:20',
        ]);

        $empresa = Empresa::create($validated);

        return response()->json(["success" => true, "data" => $empresa], 201);
    }

    public function show($id): JsonResponse
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(["success" => false, "message" => "Empresa no encontrada."], 404);
        }

        return response()->json(["success" => true, "data" => $empresa], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(["success" => false, "message" => "Empresa no encontrada."], 404);
        }

        $validated = $request->validate([
            'nombre_empresa' => 'sometimes|required|string|max:255',
            // Se usa Rule::unique para ignorar el ID actual y no arrojar error de "RUT ya existe" si no lo cambia
            'rut_empresa' => ['sometimes', 'required', 'string', 'regex:/^\d{7,8}-[\dKk]$/', Rule::unique('empresas')->ignore($empresa->id)],
            'email' => ['sometimes', 'required', 'email', Rule::unique('empresas')->ignore($empresa->id)],
            'tipo_empresa' => 'sometimes|required|in:contratacion-directa,est,outsourcing',
            'contacto_nombre' => 'sometimes|required|string|max:255',
            'contacto_email' => 'sometimes|required|email',
            'logo_url' => 'nullable|url',
            'rubro' => 'nullable|string|max:255',
            'presentacion' => 'nullable|string',
            'beneficios' => 'nullable|array',
            'contacto_telefono' => 'nullable|string|max:20',
        ]);

        $empresa->update($validated);

        return response()->json(["success" => true, "data" => $empresa], 200);
    }

    public function destroy($id): JsonResponse
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(["success" => false, "message" => "Empresa no encontrada."], 404);
        }

        // Baja lógica
        $empresa->update(['activo' => false]);

        return response()->json([
            "success" => true,
            "data" => ["message" => "Empresa desactivada exitosamente."]
        ], 200);
    }

    public function validar($id): JsonResponse
    {
        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(["success" => false, "message" => "Empresa no encontrada."], 404);
        }

        $empresa->update(['validado' => true]);

        return response()->json(["success" => true, "data" => $empresa], 200);
    }
}
