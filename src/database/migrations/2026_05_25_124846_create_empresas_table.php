<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**SWAGGER PARA IDENTIFICAR ERROR EN BASE DE DATOS
    Al intentar realizar el POST, recibía un error 500 indicando que la columna
    'presentacion' no existía.
    Corregí mi archivo de migración añadiendo la columna faltante
    para que coincida exactamente con mi modelo Empresa.php.
    Ejecute migrate:fresh para sincronizar la BD.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nombre_empresa');
            // UK (Unique Keys)
            $table->string('rut_empresa')->unique();
            $table->string('email')->unique();

            $table->string('tipo_empresa');
            $table->string('rubro')->nullable();

            // Columna añadida para evitar el error
            $table->text('presentacion')->nullable();

            // Campo JSON para lista de beneficios
            $table->json('beneficios')->nullable();

            $table->string('contacto_nombre');
            $table->string('contacto_email');
            $table->string('contacto_telefono')->nullable();

            $table->boolean('validado')->default(false);
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
