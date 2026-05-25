<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'nombre_empresa', 'rut_empresa', 'email', 'tipo_empresa',
        'rubro', 'beneficios', 'contacto_nombre', 'contacto_email', 'validado', 'activo'
    ];

    protected $casts = [
        'beneficios' => 'array',
        'validado' => 'boolean',
        'activo' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($empresa) {
            $empresa->id = (string) Str::uuid();
            $empresa->activo = true;
            $empresa->validado = false;
        });
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(ContactoSolicitado::class, 'empresa_id');
    }
}
