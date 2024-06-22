<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citai_id')->constrained('citas')->cascadeOnDelete();
            $table->timestamp('fechaHora')->useCurrent();
            $table->text('diagnostico');
            $table->text('recete');
            $table->decimal('totalPagar', 10, 2)->default(0);
            $table->foreignId('usuariomedicoid')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
