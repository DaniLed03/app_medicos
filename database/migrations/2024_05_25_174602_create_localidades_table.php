<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->unsignedBigInteger('id_localidad');
            $table->unsignedBigInteger('id_municipio');
            $table->unsignedBigInteger('id_entidad_federativa'); 
            $table->string('nombre');
            $table->timestamps();
    
            $table->primary(['id_localidad', 'id_municipio', 'id_entidad_federativa']);
            
            $table->foreign('id_municipio')
                  ->references('id_municipio')
                  ->on('municipios')
                  ->onDelete('cascade');

            $table->foreign('id_entidad_federativa')
                  ->references('id')  // Cambiar aquí a 'id'
                  ->on('entidades_federativas') 
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('localidades');
    }
};
