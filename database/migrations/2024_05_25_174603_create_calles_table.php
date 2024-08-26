<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('localidad_id');
            $table->string('nombre');
            $table->timestamps();

            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('cascade');
            $table->unique(['localidad_id', 'nombre']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('calles');
    }

};
