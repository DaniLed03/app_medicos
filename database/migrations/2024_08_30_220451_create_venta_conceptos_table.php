<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta_conceptos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->cascadeOnDelete();
            $table->unsignedBigInteger('concepto_id');
            $table->foreign('concepto_id')->references('id_concepto')->on('conceptos')->cascadeOnDelete();
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_conceptos');
    }
};
