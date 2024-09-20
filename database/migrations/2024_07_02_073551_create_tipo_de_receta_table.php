<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoDeRecetaTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_de_receta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del tipo de receta
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_de_receta');
    }
}
