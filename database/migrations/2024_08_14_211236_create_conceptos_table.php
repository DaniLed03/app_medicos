<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id('id_concepto');
            $table->string('concepto');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('impuesto', 5, 2)->nullable();
            $table->string('unidad_medida');
            $table->string('tipo_concepto');
            $table->foreignId('medico_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
