<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase se usa para crear y eliminar la tabla 'productos' en la base de datos.
return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        // Crear la tabla 'productos' para almacenar los productos ofrecidos.
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Columna para el ID único del producto.
            $table->string('nombre', 100); // Columna para el nombre del producto.
            $table->decimal('precio', 10, 2); // Columna para el precio del producto.
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para el estado (activo o inactivo) del producto, por defecto es 'si'.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina la tabla 'productos' si existe.
        Schema::dropIfExists('productos');
    }
};
