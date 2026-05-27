<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Persona',
    required: ['id', 'email'],
    properties: [
        new OA\Property(property: 'id', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'codigo_talento', type: 'string'),
        new OA\Property(property: 'nivel_educacional', type: 'string'),
        new OA\Property(property: 'activo', type: 'boolean'),
        new OA\Property(property: 'validado', type: 'boolean')
    ]
)]
class Persona extends Model
{
    protected $fillable = [
        'email', 'codigo_talento', 'nombre', 'apellido', 'nivel_educacional',
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
            // Aquí irían otros campos anonimizados
        ];
    }
}
