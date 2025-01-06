<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('talla', 255)->change();
            $table->string('peso', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->decimal('talla', 5, 2)->change();
            $table->decimal('peso', 5, 2)->change();
        });
    }

};
