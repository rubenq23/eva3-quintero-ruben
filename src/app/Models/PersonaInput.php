<?php

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PersonaInput',
    required: ['email'],
    properties: [
        new OA\Property(property: 'email', type: 'string', format: 'email'),
        new OA\Property(property: 'nombre', type: 'string'),
        new OA\Property(property: 'apellido', type: 'string'),
        new OA\Property(property: 'nivel_educacional', type: 'string')
    ]
)]
class PersonaInput
{
    // Clase de definición para Swagger
}
