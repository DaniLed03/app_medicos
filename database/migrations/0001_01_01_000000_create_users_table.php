<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Método que se ejecuta al aplicar la migración
    public function up(): void
    {
        // Crear la tabla 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna ID auto incrementada
            $table->string('nombres', 100); // Columna nombres con un máximo de 100 caracteres
            $table->string('apepat', 100); // Columna apellido paterno con un máximo de 100 caracteres
            $table->string('apemat', 100); // Columna apellido materno con un máximo de 100 caracteres
            $table->date('fechanac'); // Columna fecha de nacimiento
            $table->string('telefono', 20); // Columna teléfono con un máximo de 20 caracteres
            $table->enum('rol', ['medico', 'secretaria', 'colaborador']); // Columna rol con valores permitidos 'medico', 'secretaria', 'colaborador'
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna activo con valores 'si' y 'no', por defecto 'si'
            $table->string('email')->unique(); // Columna email única
            $table->string('password'); // Columna contraseña
            $table->timestamps(); // Columnas created_at y updated_at
        });

        // Crear la tabla 'password_reset_tokens'
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Columna email como clave primaria
            $table->string('token'); // Columna token
            $table->timestamp('created_at')->nullable(); // Columna created_at que puede ser nula
        });

        // Crear la tabla 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Columna ID como clave primaria
            $table->foreignId('user_id')->nullable()->index(); // Columna user_id que puede ser nula y está indexada
            $table->string('ip_address', 45)->nullable(); // Columna ip_address con un máximo de 45 caracteres que puede ser nula
            $table->text('user_agent')->nullable(); // Columna user_agent que puede ser nula
            $table->longText('payload'); // Columna payload
            $table->integer('last_activity')->index(); // Columna last_activity indexada
        });
    }

    // Método que se ejecuta al revertir la migración
    public function down(): void
    {
        Schema::dropIfExists('users'); // Elimina la tabla 'users' si existe
        Schema::dropIfExists('password_reset_tokens'); // Elimina la tabla 'password_reset_tokens' si existe
        Schema::dropIfExists('sessions'); // Elimina la tabla 'sessions' si existe
    }
};
