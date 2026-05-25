<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactos_solicitados', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relaciones (Foreign Keys) apuntando a las tablas correspondientes
            $table->foreignUuid('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignUuid('persona_id')->constrained('personas')->cascadeOnDelete();

            // Estado inicial por defecto según tu máquina de estados
            $table->string('estado')->default('pendiente');

            // Notas
            $table->text('notas_admin')->nullable();

            // Fechas de seguimiento
            $table->date('fecha_contacto')->nullable();
            $table->date('fecha_entrevista')->nullable();
            $table->date('fecha_resultado')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos_solicitados');
    }
};
