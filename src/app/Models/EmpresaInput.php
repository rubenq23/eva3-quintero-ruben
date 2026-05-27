<?php

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'EmpresaInput',
    required: ['nombre_empresa', 'rut_empresa', 'email', 'tipo_empresa', 'contacto_nombre', 'contacto_email'],
    properties: [
        new OA\Property(property: 'nombre_empresa', type: 'string'),
        new OA\Property(property: 'rut_empresa', type: 'string'),
        new OA\Property(property: 'email', type: 'string', format: 'email'),
        new OA\Property(property: 'tipo_empresa', type: 'string', enum: ['contratacion-directa', 'est', 'outsourcing']),
        new OA\Property(property: 'contacto_nombre', type: 'string'),
        new OA\Property(property: 'contacto_email', type: 'string', format: 'email'),
        new OA\Property(property: 'contacto_telefono', type: 'string', nullable: true),
        new OA\Property(property: 'rubro', type: 'string', nullable: true),
        new OA\Property(property: 'presentacion', type: 'string', nullable: true)
    ]
)]
class EmpresaInput
{
    // Clase de definición para Swagger
}
