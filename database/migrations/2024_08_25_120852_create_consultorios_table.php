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
            $table->string('entidad_federativa', 150)->nullable();
            $table->string('municipio', 150)->nullable();
            $table->string('localidad', 150)->nullable();
            $table->string('calle', 150)->nullable();
            $table->string('colonia', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('cedula_profesional', 50)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('facultad_medicina', 150)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultorios');
    }
};
