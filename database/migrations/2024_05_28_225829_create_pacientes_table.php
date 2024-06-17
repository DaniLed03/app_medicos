<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Método que se ejecuta al aplicar la migración
    public function up(): void
    {
        // Crear la tabla 'pacientes'
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id(); // Columna ID auto incrementada
            $table->string('nombres', 100); // Columna nombres con un máximo de 100 caracteres
            $table->string('apepat', 100); // Columna apellido paterno con un máximo de 100 caracteres
            $table->string('apemat', 100); // Columna apellido materno con un máximo de 100 caracteres
            $table->date('fechanac'); // Columna fecha de nacimiento
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna activo con valores 'si' y 'no', por defecto 'si'
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    // Método que se ejecuta al revertir la migración
    public function down(): void
    {
        Schema::dropIfExists('pacientes'); // Elimina la tabla 'pacientes' si existe
    }
};
