<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipio_id');
            $table->string('nombre');
            $table->timestamps();
    
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
            $table->unique(['municipio_id', 'nombre']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
    
};