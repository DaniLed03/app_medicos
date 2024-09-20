<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->unsignedBigInteger('usuariomedicoid');
            $table->unsignedBigInteger('pacienteid');
            $table->unsignedBigInteger('id'); // Asegúrate de que el tipo coincida
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
            $table->string('circunferencia_cabeza')->nullable();
            $table->timestamps();

            // Crear un índice único en lugar de una clave primaria
            $table->unique([ 'usuariomedicoid', 'pacienteid', 'id']);

            // Crear un índice en la columna 'id' (si es necesario)
            $table->index('id');

            // Foreign keys
            $table->foreign('pacienteid')->references('no_exp')->on('pacientes')->onDelete('cascade');
            $table->foreign('usuariomedicoid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
