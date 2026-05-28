<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class EmpresaController extends Controller
{
    /**USO DE SWAGGER UI PARA IDENTIFICAR ERRORES
    Mis path no tenian el prefijo v1 (el que defini en mi ruta en api.php)
    por eso al presionar try it out me daban un 404.
    Corregi el path y funciono con una respuesta 201.
     */

    #[OA\Get(
        path: '/v1/empresas',
        operationId: 'getEmpresas',
        tags: ['Empresas'],
        summary: 'Listar empresas validadas',
        parameters: [
            new OA\Parameter(name: 'tipo_empresa', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['contratacion-directa', 'est', 'outsourcing']))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Listado exitoso', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Empresa')))
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $query = Empresa::where('activo', true);
        if ($request->has('tipo_empresa')) {
            $query->where('tipo_empresa', $request->input('tipo_empresa'));
        }
        return $this->successResponse($query->get());
    }

    #[OA\Post(
        path: '/v1/empresas',
        operationId: 'createEmpresa',
        tags: ['Empresas'],
        summary: 'Registrar nueva empresa',
        // --- Ejemplo detallado en el requestBody ---
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EmpresaInput')
        ),
        // -----------------------------------------------------------------
        responses: [
            new OA\Response(response: 201, description: 'Empresa creada', content: new OA\JsonContent(ref: '#/components/schemas/Empresa')),
            new OA\Response(response: 422, description: 'Errores de validación')
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre_empresa'    => 'required|string|max:255',
            'rut_empresa'       => 'required|string|max:20|unique:empresas,rut_empresa',
            'email'             => 'required|email|unique:empresas,email',
            'logo_url'          => 'nullable|url',
            'rubro'             => 'nullable|string|max:100',
            'tipo_empresa'      => 'required|in:contratacion-directa,est,outsourcing',
            'presentacion'      => 'nullable|string',
            'beneficios'        => 'nullable|array',
            'contacto_nombre'   => 'required|string|max:100',
            'contacto_email'    => 'required|email',
            'contacto_telefono' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Los datos enviados no son válidos.', 422, $validator->errors()->toArray());
        }

        return $this->successResponse(Empresa::create($validator->validated()), 201);
    }

    #[OA\Get(
        path: '/v1/empresas/{id}',
        operationId: 'getEmpresa',
        tags: ['Empresas'],
        summary: 'Obtener empresa por ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [
            new OA\Response(response: 200, description: 'Empresa encontrada', content: new OA\JsonContent(ref: '#/components/schemas/Empresa')),
            new OA\Response(response: 404, description: 'No encontrada')
        ]
    )]
    public function show(string $id): JsonResponse
    {
        $model = Empresa::find($id);
        return $model ? $this->successResponse($model) : $this->errorResponse('Empresa no encontrada.', 404);
    }

    #[OA\Put(
        path: '/v1/empresas/{id}',
        operationId: 'updateEmpresa',
        tags: ['Empresas'],
        summary: 'Actualizar empresa',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        // --- Ejemplo detallado en el requestBody ---
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/EmpresaInput')),
        // -----------------------------------------------------------------
        responses: [
            new OA\Response(response: 200, description: 'Empresa actualizada'),
            new OA\Response(response: 404, description: 'No encontrada')
        ]
    )]
    public function update(Request $request, string $id): JsonResponse
    {
        $model = Empresa::find($id);
        if (!$model) return $this->errorResponse('Empresa no encontrada.', 404);

        $validator = Validator::make($request->all(), [
            'nombre_empresa'    => 'sometimes|string|max:255',
            'rut_empresa'       => 'sometimes|string|max:20|unique:empresas,rut_empresa,' . $model->id,
            'email'             => 'sometimes|email|unique:empresas,email,' . $model->id,
            'tipo_empresa'      => 'sometimes|in:contratacion-directa,est,outsourcing',
            'contacto_nombre'   => 'sometimes|string|max:100',
            'contacto_email'    => 'sometimes|email',
        ]);

        if ($validator->fails()) return $this->errorResponse('Datos no válidos.', 422, $validator->errors()->toArray());

        $model->update($validator->validated());
        return $this->successResponse($model->fresh());
    }

    #[OA\Patch(
        path: '/v1/empresas/{id}/validar',
        operationId: 'validarEmpresa',
        tags: ['Empresas'],
        summary: 'Validar empresa',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'Empresa validada'), new OA\Response(response: 404, description: 'No encontrada')]
    )]
    public function validar(string $id): JsonResponse
    {
        $model = Empresa::find($id);
        return $model ? $this->successResponse(['message' => 'Validada', 'data' => tap($model)->update(['validado' => true])->fresh()]) : $this->errorResponse('No encontrada', 404);
    }

    #[OA\Delete(
        path: '/v1/empresas/{id}',
        operationId: 'deleteEmpresa',
        tags: ['Empresas'],
        summary: 'Desactivar empresa',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'Desactivada'), new OA\Response(response: 404, description: 'No encontrada')]
    )]
    public function destroy(string $id): JsonResponse
    {
        $model = Empresa::find($id);
        if (!$model) return $this->errorResponse('No encontrada', 404);
        $model->update(['activo' => false]);
        return $this->successResponse(['message' => 'Desactivada']);
    }
}
