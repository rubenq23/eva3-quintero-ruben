<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            // Se usa uuid en lugar de id() autoincremental
            $table->uuid('id')->primary();

            // UK (Unique Keys)
            $table->string('email')->unique();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('codigo_talento')->unique();

            $table->string('telefono')->nullable();
            $table->string('nivel_educacional')->nullable();
            $table->string('titulo_carrera')->nullable();
            $table->integer('año_egreso')->nullable();
            $table->integer('años_experiencia')->nullable();

            // Campos JSON para almacenar arreglos
            $table->json('competencias')->nullable();
            $table->json('areas_experiencia')->nullable();

            $table->string('rango_renta')->nullable();
            $table->string('tipo_jornada')->nullable();
            $table->string('modalidad')->nullable();

            // Campos JSON adicionales
            $table->json('cursos')->nullable();
            $table->json('idiomas')->nullable();

            // Booleanos e Integers con valores por defecto
            $table->boolean('persona_discapacidad')->default(false);
            $table->boolean('validado')->default(false);
            $table->boolean('activo')->default(true);
            $table->integer('porcentaje_completitud')->default(55);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
