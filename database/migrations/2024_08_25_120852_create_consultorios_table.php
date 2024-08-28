<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultorios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('logo')->nullable();
            $table->string('nombre', 255)->nullable();
            $table->unsignedBigInteger('entidad_federativa_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->string('calle', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('cedula_profesional', 50)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('facultad_medicina', 150)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('entidad_federativa_id')->references('id')->on('entidades_federativas')->onDelete('set null');
            $table->foreign('municipio_id')->references('id_municipio')->on('municipios')->onDelete('set null');
            $table->foreign('localidad_id')->references('id_localidad')->on('localidades')->onDelete('set null');
            $table->foreign('colonia_id')->references('id_asentamiento')->on('colonias')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultorios');
    }
};
