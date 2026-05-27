<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Empresa',
    required: ['id', 'nombre_empresa', 'rut_empresa'],
    properties: [
        new OA\Property(property: 'id', type: 'string'),
        new OA\Property(property: 'nombre_empresa', type: 'string'),
        new OA\Property(property: 'rut_empresa', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'tipo_empresa', type: 'string'),
        new OA\Property(property: 'activo', type: 'boolean'),
        new OA\Property(property: 'validado', type: 'boolean')
    ]
)]
class Empresa extends Model
{
    protected $fillable = [
        'nombre_empresa', 'rut_empresa', 'email', 'logo_url', 'rubro',
        'tipo_empresa', 'presentacion', 'beneficios', 'contacto_nombre',
        'contacto_email', 'contacto_telefono', 'activo', 'validado'
    ];

    protected $casts = [
        'beneficios' => 'array',
        'activo' => 'boolean',
        'validado' => 'boolean',
    ];
}
