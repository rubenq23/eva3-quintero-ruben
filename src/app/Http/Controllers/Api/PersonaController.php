<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class PersonaController extends Controller
{
    #[OA\Get(
        path: '/personas',
        operationId: 'getPersonas',
        tags: ['Personas'],
        summary: 'Listar personas',
        parameters: [
            new OA\Parameter(name: 'validado', in: 'query', schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'nivel_educacional', in: 'query', schema: new OA\Schema(type: 'string'))
        ],
        responses: [new OA\Response(response: 200, description: 'OK', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/PersonaCVCiego')))]
    )]
    public function index(Request $request): JsonResponse
    {
        $query = Persona::where('activo', true);
        if ($request->has('validado')) $query->where('validado', $request->boolean('validado'));
        if ($request->has('nivel_educacional')) $query->where('nivel_educacional', $request->input('nivel_educacional'));
        return $this->successResponse($query->get()->map(fn($p) => $p->getCvCiego()));
    }

    #[OA\Post(
        path: '/personas',
        operationId: 'createPersona',
        tags: ['Personas'],
        summary: 'Registrar persona',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PersonaInput')),
        responses: [new OA\Response(response: 201, description: 'Creada')]
    )]
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:personas,email',
        ]);
        if ($validator->fails()) return $this->errorResponse('Error', 422, $validator->errors()->toArray());

        $data = $validator->validated();
        $data['codigo_talento'] = 'PROV-' . date('Y') . '-' . strtoupper(Str::random(4));
        return $this->successResponse(Persona::create($data), 201);
    }

    #[OA\Get(
        path: '/personas/{id}',
        operationId: 'getPersona',
        tags: ['Personas'],
        summary: 'Obtener por ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function show(string $id): JsonResponse
    {
        $model = Persona::find($id);
        return $model ? $this->successResponse($model) : $this->errorResponse('No encontrada', 404);
    }

    #[OA\Put(
        path: '/personas/{id}',
        operationId: 'updatePersona',
        tags: ['Personas'],
        summary: 'Actualizar',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/PersonaInput')),
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function update(Request $request, string $id): JsonResponse
    {
        $model = Persona::find($id);
        if (!$model) return $this->errorResponse('No encontrada', 404);
        $model->update($request->all());
        return $this->successResponse($model->fresh());
    }

    #[OA\Patch(
        path: '/personas/{id}/validar',
        operationId: 'validarPersona',
        tags: ['Personas'],
        summary: 'Validar',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function validar(string $id): JsonResponse
    {
        $model = Persona::find($id);
        return $model ? $this->successResponse(tap($model)->update(['validado' => true])->fresh()) : $this->errorResponse('No encontrada', 404);
    }

    #[OA\Delete(
        path: '/personas/{id}',
        operationId: 'deletePersona',
        tags: ['Personas'],
        summary: 'Desactivar',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))],
        responses: [new OA\Response(response: 200, description: 'OK')]
    )]
    public function destroy(string $id): JsonResponse
    {
        $model = Persona::find($id);
        if (!$model) return $this->errorResponse('No encontrada', 404);
        $model->update(['activo' => false]);
        return $this->successResponse(['message' => 'Desactivada']);
    }
}
