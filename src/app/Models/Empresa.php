<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Necesario para generar el UUID
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Empresa',
    required: ['id', 'nombre_empresa', 'rut_empresa'],
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
        new OA\Property(property: 'nombre_empresa', type: 'string', example: 'Empresa Ejemplo S.A.'),
        new OA\Property(property: 'rut_empresa', type: 'string', example: '12.345.678-9'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'contacto@empresa.cl'),
        new OA\Property(property: 'tipo_empresa', type: 'string', example: 'Startup'),
        new OA\Property(property: 'activo', type: 'boolean', example: true),
        new OA\Property(property: 'validado', type: 'boolean', example: false)
    ]
)]
class Empresa extends Model
{
    // 1. Configuración de clave primaria (UUID)
    public $incrementing = false;
    protected $keyType = 'string';

    // 2. Generación automática del UUID al crear
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'id', 'nombre_empresa', 'rut_empresa', 'email', 'logo_url', 'rubro',
        'tipo_empresa', 'presentacion', 'beneficios', 'contacto_nombre',
        'contacto_email', 'contacto_telefono', 'activo', 'validado'
    ];

    protected $casts = [
        'beneficios' => 'array',
        'activo' => 'boolean',
        'validado' => 'boolean',
    ];
}
