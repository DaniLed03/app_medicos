<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_concepto');  // Quitar el autoincrementable
            $table->string('concepto');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('impuesto', 5, 2)->nullable();
            $table->string('unidad_medida');
            $table->string('tipo_concepto');
            $table->foreignId('medico_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            // Crear la llave compuesta y restricción única
            $table->primary(['id_concepto', 'medico_id']);  // Usar como llave primaria compuesta
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
