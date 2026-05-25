<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
