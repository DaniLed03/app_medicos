<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citai_id')->constrained('citas')->cascadeOnDelete();
            $table->timestamp('fechaHora')->useCurrent();
            $table->string('talla')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('saturacion_oxigeno')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('peso')->nullable();
            $table->string('tension_arterial')->nullable();
            $table->text('motivoConsulta');
            $table->text('notas_padecimiento')->nullable();
            $table->text('interrogatorio_por_aparatos')->nullable();
            $table->text('examen_fisico')->nullable();
            $table->text('diagnostico');
            $table->text('plan')->nullable();
            $table->string('status')->default('en curso');
            $table->decimal('totalPagar', 10, 2)->default(0);
            $table->foreignId('usuariomedicoid')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};