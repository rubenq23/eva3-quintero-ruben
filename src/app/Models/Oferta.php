<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importante para la relación

class Oferta extends Model {

    // Indica que la tabla se llama 'ofertas' (opcional si ya sigue el estándar)
    protected $table = 'ofertas';

    // Permite el llenado masivo de estos campos
    protected $fillable = ['titulo', 'descripcion', 'activa'];

    /**
     * Relación Uno a Muchos
     * Una oferta puede tener muchas postulaciones.
     */
    public function postulaciones(): HasMany
    {
        // 'oferta_id' es la llave foránea en la tabla 'postulaciones'
        return $this->hasMany(Postulacion::class, 'oferta_id');
    }
}
