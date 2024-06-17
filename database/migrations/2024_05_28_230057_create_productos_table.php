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
        // Crear la tabla 'productos'
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Columna ID auto incrementada
            $table->string('nombre', 100); // Columna nombre con un máximo de 100 caracteres
            $table->decimal('precio', 10, 2); // Columna precio con 10 dígitos en total y 2 decimales
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna activo con valores 'si' y 'no', por defecto 'si'
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Método que se ejecuta al revertir la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('productos'); // Elimina la tabla 'productos' si existe
    }
};
