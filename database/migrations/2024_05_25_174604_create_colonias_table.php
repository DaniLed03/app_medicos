<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('colonias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('calle_id');
            $table->string('nombre');
            $table->timestamps();

            $table->foreign('calle_id')->references('id')->on('calles')->onDelete('cascade');
            $table->unique(['calle_id', 'nombre']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('colonias');
    }

};
