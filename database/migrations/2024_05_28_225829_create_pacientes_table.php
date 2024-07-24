<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('no_exp', 100)->nullable()->unique(); // Número de expediente
            $table->string('nombres', 100);
            $table->string('apepat', 100);
            $table->string('apemat', 100);
            $table->date('fechanac');
            $table->time('hora')->nullable();
            $table->float('peso')->nullable();
            $table->float('talla')->nullable();
            $table->string('lugar_naci', 255)->nullable();
            $table->string('hospital', 255)->nullable();
            $table->string('tipoparto', 255)->nullable();
            $table->string('tiposangre', 255)->nullable();
            $table->text('antecedentes')->nullable();
            $table->string('padre', 255)->nullable();
            $table->string('madre', 255)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('correo', 255)->nullable()->unique();
            $table->string('telefono', 20);
            $table->string('telefono2', 20)->nullable();
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->string('curp', 18)->nullable()->unique(); // Add this line for CURP
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
