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
            $table->unsignedBigInteger('id');
            $table->timestamp('fechaHora')->useCurrent();
            $table->string('talla')->nullable();
            $table->string('temperatura')->nullable();
            $table->string('saturacion_oxigeno')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('peso')->nullable();
            $table->string('tension_arterial')->nullable();
            $table->string('circunferencia_cabeza')->nullable();
            $table->integer('años')->nullable();  // Nuevo campo
            $table->integer('meses')->nullable(); // Nuevo campo
            $table->integer('dias')->nullable();  // Nuevo campo
            $table->text('motivoConsulta');
            $table->text('diagnostico');
            $table->string('status')->default('en curso');
            $table->decimal('totalPagar', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['usuariomedicoid', 'pacienteid', 'id']);
            $table->index('id');
            $table->foreign('pacienteid')->references('no_exp')->on('pacientes')->onDelete('cascade');
            $table->foreign('usuariomedicoid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
