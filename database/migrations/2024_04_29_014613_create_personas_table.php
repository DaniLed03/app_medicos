<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apepat');
            $table->string('apemat');
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->date('fechanac');
            $table->string('curp')->unique();
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->string('password')->nullable(); // Hacer opcional
            $table->unsignedBigInteger('medico_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('medico_id')->references('id')->on('users')->onDelete('cascade');

            // Composite key
            $table->unique(['id', 'medico_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
