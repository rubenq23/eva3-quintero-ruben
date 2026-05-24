<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Postulacion extends Model {
    protected $table = 'postulaciones';
    protected $fillable = ['oferta_id', 'nombre_candidato', 'email_candidato', 'estado'];

    // Esta permite que el candidato vea su historial de comentarios
    public function comentarios(): HasMany {
        return $this->hasMany(Comentario::class, 'postulaciones_id');
    }
}
