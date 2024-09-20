<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Agregar los campos que hacen referencia a la clave primaria compuesta en la tabla pacientes
            $table->unsignedBigInteger('no_exp')->nullable();
            $table->unsignedBigInteger('medico_id')->nullable();

            // Definir las claves foráneas con respecto a los campos no_exp y medico_id de la tabla pacientes
            $table->foreign(['no_exp', 'medico_id'])->references(['no_exp', 'medico_id'])->on('pacientes')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::table('ventas', function (Blueprint $table) {
            // Eliminar las claves foráneas y columnas en caso de revertir la migración
            $table->dropForeign(['no_exp', 'medico_id']);
            $table->dropColumn(['no_exp', 'medico_id']);
        });
    }
};
