<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('colonias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_asentamiento');
            $table->unsignedBigInteger('id_entidad');
            $table->unsignedBigInteger('id_municipio');
            $table->string('cp');
            $table->string('asentamiento');
            $table->string('tipo_asentamiento');
            $table->timestamps();

            // Definir la llave primaria compuesta
            $table->primary(['id_asentamiento', 'id_entidad', 'id_municipio']);
            
            // Definir las relaciones
            $table->foreign('id_entidad')->references('id')->on('entidades_federativas')->onDelete('cascade');
            $table->foreign('id_municipio')->references('id_municipio')->on('municipios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('colonias');
    }
};
