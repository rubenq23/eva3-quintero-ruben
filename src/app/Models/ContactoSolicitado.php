<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ContactoSolicitado',
    required: ['id', 'empresa_id', 'persona_id', 'estado'],
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'empresa_id', type: 'string'),
        new OA\Property(property: 'persona_id', type: 'string'),
        new OA\Property(property: 'estado', type: 'string', enum: ['pendiente', 'contactado', 'entrevista', 'seleccionado', 'no-seleccionado', 'proceso-cerrado']),
        new OA\Property(property: 'notas_admin', type: 'string', nullable: true),
        new OA\Property(property: 'fecha_contacto', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'fecha_entrevista', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'fecha_resultado', type: 'string', format: 'date-time', nullable: true)
    ]
)]
class ContactoSolicitado extends Model
{
    protected $table = 'contactos_solicitados';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'empresa_id', 'persona_id', 'estado', 'notas_admin',
        'fecha_contacto', 'fecha_entrevista', 'fecha_resultado'
    ];

    protected static function booted()
    {
        static::creating(function ($contacto) {
            $contacto->id = (string) Str::uuid();
            $contacto->estado = 'pendiente';
        });
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
