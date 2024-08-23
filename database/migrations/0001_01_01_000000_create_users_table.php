<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apepat', 100)->nullable();
            $table->string('apemat', 100)->nullable();
            $table->date('fechanac')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->enum('sexo', ['masculino', 'femenino'])->nullable();
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable(); // <- Agrega esta línea
            $table->unsignedBigInteger('medico_id')->nullable();
            $table->timestamps();
        
            $table->foreign('medico_id')->references('id')->on('users')->onDelete('cascade');
        });
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
