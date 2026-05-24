<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {
    protected $table = 'comentarios';
    protected $fillable = ['postulaciones_id', 'texto'];

    public function postulacion()
    {
        return $this->belongsTo(Postulacion::class, 'postulaciones_id');
    }

}
