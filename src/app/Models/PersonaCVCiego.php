<?php

namespace App\Models;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PersonaCVCiego',
    required: ['id', 'nivel_educacional'],
    properties: [
        new OA\Property(property: 'id', type: 'string'),
        new OA\Property(property: 'nivel_educacional', type: 'string')
    ]
)]
class PersonaCVCiego
{
    /** @OA\Property() */
    public string $id;

    /** @OA\Property() */
    public string $nivel_educacional;
}
