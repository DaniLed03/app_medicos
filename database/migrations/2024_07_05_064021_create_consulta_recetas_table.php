<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaRecetasTable extends Migration
{
    public function up()
    {
        Schema::create('consulta_recetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->string('tipo_de_receta'); // New field
            $table->text('receta'); // New field
            $table->timestamps();

            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consulta_recetas');
    }
}
