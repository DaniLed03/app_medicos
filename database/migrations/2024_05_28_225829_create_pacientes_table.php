<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('no_exp');
            $table->string('nombres');
            $table->string('apepat');
            $table->string('apemat');
            $table->date('fechanac')->nullable();
            $table->time('hora')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->integer('talla')->nullable();
            $table->string('lugar_naci')->nullable();
            $table->string('hospital')->nullable();
            $table->string('tipoparto')->nullable();
            $table->string('tiposangre')->nullable();
            $table->text('antecedentes')->nullable();
            $table->string('padre')->nullable();
            $table->string('madre')->nullable();
            $table->unsignedBigInteger('entidad_federativa_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->unsignedBigInteger('calle_id')->nullable();
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono');
            $table->string('telefono2')->nullable();
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->string('curp')->unique()->nullable();
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->string('Nombre_fact')->nullable();
            $table->string('Direccion_fact')->nullable();
            $table->string('RFC')->nullable();
            $table->string('Regimen_fiscal')->nullable();
            $table->string('CFDI')->nullable();
            $table->unsignedBigInteger('medico_id');
            $table->timestamps();

            // Foreign Keys
            $table->foreign('medico_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('entidad_federativa_id')->references('id')->on('entidades_federativas')->onDelete('set null');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('set null');
            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('set null');
            $table->foreign('calle_id')->references('id')->on('calles')->onDelete('set null');
            $table->foreign('colonia_id')->references('id')->on('colonias')->onDelete('set null');

            $table->unique(['medico_id', 'no_exp']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
