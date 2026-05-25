<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            // Campo JSON para lista de beneficios
            $table->json('beneficios')->nullable();

            $table->string('contacto_nombre');
            $table->string('contacto_email');

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
