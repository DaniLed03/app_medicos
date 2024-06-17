<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Método que se ejecuta al aplicar la migración
     */
    public function up(): void
    {
        // Crear la tabla 'citas'
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); // Columna ID auto incrementada
            $table->date('fecha'); // Columna fecha
            $table->time('hora'); // Columna hora
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna activo con valores 'si' y 'no', por defecto 'si'
            // Columna pacienteid que referencia la tabla 'pacientes', eliminando en cascada si el paciente es eliminado
            $table->foreignId('pacienteid')->constrained('pacientes')->onDelete('cascade');
            // Columna usuariomedicoid que referencia la tabla 'users', eliminando en cascada si el usuario médico es eliminado
            $table->foreignId('usuariomedicoid')->constrained('users')->onDelete('cascade');
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Método que se ejecuta al revertir la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('citas'); // Elimina la tabla 'citas' si existe
    }
};
