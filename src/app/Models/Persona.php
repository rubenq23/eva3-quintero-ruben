<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Importante para generar el UUID
use OpenApi\Attributes as OA;

/**EJEMPLO DE DATOS
 Para cumplir con el punto 3 de la rubrica inclui ejemplos de datos.
 Estos pueden ser visualizados al entrar en el apartado de Personas.
 Metodo POST*/

#[OA\Schema(
    schema: 'Persona',
    required: ['id', 'email'],
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
        new OA\Property(property: 'email', type: 'string', format: 'email', example: 'talento@ejemplo.cl'),
        new OA\Property(property: 'codigo_talento', type: 'string', example: 'TAL-2026-001'),
        new OA\Property(property: 'nombre', type: 'string', example: 'Juan'),
        new OA\Property(property: 'apellido', type: 'string', example: 'Pérez'),
        new OA\Property(property: 'nivel_educacional', type: 'string', example: 'universitaria'),
        new OA\Property(property: 'activo', type: 'boolean', example: true),
        new OA\Property(property: 'validado', type: 'boolean', example: false)
    ]
)]
class Persona extends Model
{
    // 1. Indicar que el ID no es autoincremental
    public $incrementing = false;

    // 2. Indicar que el tipo de clave es string (por el UUID)
    protected $keyType = 'string';

    // 3. Generar el UUID automáticamente al crear el modelo
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Asegúrate de incluir 'id' en el fillable
    protected $fillable = [
        'id', 'email', 'codigo_talento', 'nombre', 'apellido', 'nivel_educacional',
        'activo', 'validado'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'validado' => 'boolean',
    ];

    public function getCvCiego()
    {
        return [
            'id' => $this->id,
            'nivel_educacional' => $this->nivel_educacional,
        ];
    }
}
