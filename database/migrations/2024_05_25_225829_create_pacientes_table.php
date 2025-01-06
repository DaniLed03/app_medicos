<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->unsignedBigInteger('medico_id');
            $table->unsignedBigInteger('no_exp');
            $table->string('nombres');
            $table->string('apepat');
            $table->string('apemat');
            $table->date('fechanac')->nullable();
            $table->time('hora')->nullable();
            $table->string('peso')->nullable();
            $table->string('talla')->nullable();
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
            $table->string('calle')->nullable();
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono');
            $table->string('telefono2')->nullable();
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->string('curp')->nullable(); // Elimina la restricción única de esta columna
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->string('Nombre_fact')->nullable();
            $table->string('Direccion_fact')->nullable();
            $table->string('RFC')->nullable();
            $table->string('Regimen_fiscal')->nullable();
            $table->string('CFDI')->nullable();
            $table->timestamps();

            // Índice único para las combinaciones de columnas
            $table->unique(['curp', 'medico_id'], 'unique_curp_medico');
            $table->unique(['no_exp', 'medico_id'], 'unique_no_exp_medico');
            
            // Foreign Keys
            $table->foreign('medico_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('entidad_federativa_id')->references('id')->on('entidades_federativas')->onDelete('set null');
            $table->foreign(['municipio_id', 'entidad_federativa_id'], 'fk_pacientes_municipio')
                  ->references(['id_municipio', 'entidad_federativa_id'])
                  ->on('municipios')
                  ->onDelete('set null');
            $table->foreign(['localidad_id', 'municipio_id', 'entidad_federativa_id'], 'fk_pacientes_localidad')
                  ->references(['id_localidad', 'id_municipio', 'id_entidad_federativa'])
                  ->on('localidades')
                  ->onDelete('set null');
            $table->foreign(['colonia_id', 'entidad_federativa_id', 'municipio_id'], 'fk_pacientes_colonia')
                  ->references(['id_asentamiento', 'id_entidad', 'id_municipio'])
                  ->on('colonias')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
