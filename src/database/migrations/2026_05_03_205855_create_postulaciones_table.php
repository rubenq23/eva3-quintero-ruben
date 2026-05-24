<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('postulaciones', function (Blueprint $table) {
        $table->id();

        // Relación con la tabla Ofertas: Si la oferta no existe, no puede haber postulación.
        $table->foreignId('oferta_id')->constrained();

        $table->string('nombre_candidato');
        $table->string('email_candidato');

        // Implementamos los estados solicitados por el perfil del reclutador.
        // Uso de enum para que la base de datos solo acepte estos valores exactos.
        $table->enum('estado', [
            'Postulando',
            'Revisando',
            'Entrevista Psicológica',
            'Entrevista Personal',
            'Seleccionado',
            'Descartado'
        ])->default('Postulando'); // El estado inicial siempre será 'Postulando'

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
