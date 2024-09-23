<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosMedicosTable extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('users')->cascadeOnDelete();
            $table->date('fecha')->nullable(); // Puede ser nulo si es un horario recurrente
            $table->enum('dia_semana', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'])->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('duracion_sesion'); // Duración de cada sesión en minutos
            $table->enum('turno', ['Matutino', 'Vespertino', 'Nocturno'])->nullable(); // Nuevo campo Turno
            $table->boolean('disponible')->default(true); // Indica si estará disponible o no
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_medicos');
    }
}
