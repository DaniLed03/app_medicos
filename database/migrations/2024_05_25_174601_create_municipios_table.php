<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entidad_federativa_id');
            $table->string('nombre');
            $table->timestamps();

            $table->foreign('entidad_federativa_id')->references('id')->on('entidades_federativas')->onDelete('cascade');
            $table->unique(['entidad_federativa_id', 'nombre']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipios');
    }

};