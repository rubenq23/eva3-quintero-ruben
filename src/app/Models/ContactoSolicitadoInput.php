<?php

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ContactoSolicitadoInput',
    required: ['empresa_id', 'persona_id'],
    properties: [
        new OA\Property(property: 'empresa_id', type: 'string'),
        new OA\Property(property: 'persona_id', type: 'string'),
        new OA\Property(property: 'notas_admin', type: 'string', nullable: true)
    ]
)]
class ContactoSolicitadoInput
{
    // Esta clase solo sirve para que Swagger reconozca el esquema del formulario
}
