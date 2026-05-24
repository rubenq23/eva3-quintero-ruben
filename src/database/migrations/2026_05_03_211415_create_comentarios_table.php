<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('comentarios', function (Blueprint $table) {
        $table->id();

        // relaciona el comentario con una postulación específica.
        $table->foreignId('postulaciones_id')->constrained();

        // Campo para que el reclutador escriba sus observaciones.
        $table->text('texto');

        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
