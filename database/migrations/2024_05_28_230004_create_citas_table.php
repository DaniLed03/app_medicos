<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->string('motivo_consulta')->nullable();
            // Quitamos 'persona_id' y agregamos 'no_exp' que referencia a 'pacientes'
            $table->foreignId('no_exp')->constrained('pacientes', 'no_exp')->cascadeOnDelete();
            // Corregimos la columna 'medicoid' para que referencia 'id' de la tabla 'users'
            $table->foreignId('medicoid')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
