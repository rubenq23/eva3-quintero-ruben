<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="ContactoSolicitadoInput",
 *     title="Contacto Solicitado Input",
 *     required={"empresa_id", "persona_id"}
 * )
 */
class ContactoSolicitadoInputSchema
{
    /** @OA\Property(property="empresa_id",  type="integer", example=1) */
    public int $empresa_id;
    /** @OA\Property(property="persona_id",  type="integer", example=1) */
    public int $persona_id;
    /** @OA\Property(property="notas_admin", type="string", nullable=true) */
    public ?string $notas_admin;
}
