<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaRecetasTable extends Migration
{
    public function up()
    {
        Schema::create('consulta_recetas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_medico'); 
            $table->unsignedBigInteger('no_exp');            
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('id'); 
            $table->unsignedBigInteger('id_tiporeceta')->nullable(); 
            $table->text('receta');

            // Crear un índice único en lugar de una clave primaria
            $table->unique(['id_medico', 'no_exp', 'consulta_id', 'id']);

            // Relación con la tabla consultas
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');

            // Relación con la tabla tipo_de_receta
            $table->foreign('id_tiporeceta')->references('id')->on('tipo_de_receta')->onDelete('cascade');

            // Otras relaciones
            $table->foreign('id_medico')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('no_exp')->references('no_exp')->on('pacientes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consulta_recetas');
    }
}
