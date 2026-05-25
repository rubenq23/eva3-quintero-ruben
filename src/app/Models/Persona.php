<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Persona extends Model
{
    protected $table = 'personas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'email', 'telefono', 'codigo_talento', 'resumen', 'nivel_educacional',
        'titulo_carrera', 'año_egreso', 'años_experiencia', 'competencias',
        'areas_experiencia', 'rango_renta', 'tipo_jornada', 'modalidad',
        'cursos', 'idiomas', 'persona_discapacidad', 'validado', 'activo', 'porcentaje_completitud'
    ];

    protected $casts = [
        'competencias' => 'array',
        'areas_experiencia' => 'array',
        'cursos' => 'array',
        'idiomas' => 'array',
        'persona_discapacidad' => 'boolean',
        'validado' => 'boolean',
        'activo' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($persona) {
            $persona->id = (string) Str::uuid();
            $persona->codigo_talento = 'PROV-' . date('Y') . '-' . strtoupper(Str::random(4));
            $persona->activo = true;
            $persona->validado = false;
            $persona->porcentaje_completitud = 55; // Valor base por campos iniciales requeridos
        });
    }

    public function contactos(): HasMany
    {
        return $this->hasMany(ContactoSolicitado::class, 'persona_id');
    }
}
