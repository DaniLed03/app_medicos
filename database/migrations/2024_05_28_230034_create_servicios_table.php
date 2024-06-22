<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase se usa para crear y eliminar la tabla 'servicios' en la base de datos.
return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        // Crear la tabla 'servicios' para almacenar los servicios ofrecidos.
        Schema::create('servicios', function (Blueprint $table) {
            $table->id(); // Columna para el ID único del servicio.
            $table->string('nombre', 100); // Columna para el nombre del servicio.
            $table->decimal('precio', 10, 2); // Columna para el precio del servicio.
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para el estado (activo o inactivo) del servicio, por defecto es 'si'.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina la tabla 'servicios' si existe.
        Schema::dropIfExists('servicios');
    }
};
