<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase anónima se usa para crear y eliminar tablas en la base de datos.
return new class extends Migration
{
    // Método que se ejecuta al aplicar la migración (crear tablas).
    public function up(): void
    {
        // Crear la tabla 'users' para almacenar la información de los usuarios.
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna para el ID único del usuario.
            $table->string('nombres', 100); // Columna para los nombres del usuario.
            $table->string('apepat', 100); // Columna para el apellido paterno.
            $table->string('apemat', 100); // Columna para el apellido materno.
            $table->date('fechanac'); // Columna para la fecha de nacimiento.
            $table->string('telefono', 20); // Columna para el teléfono.
            $table->enum('rol', ['medico', 'secretaria', 'colaborador', 'admin']); // Columna para el rol del usuario.
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para el estado (activo o inactivo) del usuario, por defecto es 'si'.
            $table->string('email')->unique(); // Columna para el correo electrónico, que debe ser único.
            $table->string('password'); // Columna para la contraseña.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });

        // Crear la tabla 'password_reset_tokens' para almacenar tokens de restablecimiento de contraseña.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Columna para el correo electrónico, que es la clave primaria.
            $table->string('token'); // Columna para el token de restablecimiento.
            $table->timestamp('created_at')->nullable(); // Columna para la fecha de creación, puede ser nula.
        });

        // Crear la tabla 'sessions' para almacenar sesiones de usuarios.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Columna para el ID de la sesión, que es la clave primaria.
            $table->foreignId('user_id')->nullable()->index(); // Columna para el ID del usuario asociado, puede ser nula y tiene un índice.
            $table->string('ip_address', 45)->nullable(); // Columna para la dirección IP, puede ser nula.
            $table->text('user_agent')->nullable(); // Columna para el agente de usuario (navegador), puede ser nula.
            $table->longText('payload'); // Columna para la información de la sesión.
            $table->integer('last_activity')->index(); // Columna para registrar la última actividad de la sesión, tiene un índice.
        });
    }

    // Método que se ejecuta al revertir la migración (eliminar tablas).
    public function down(): void
    {
        Schema::dropIfExists('users'); // Elimina la tabla 'users'.
        Schema::dropIfExists('password_reset_tokens'); // Elimina la tabla 'password_reset_tokens'.
        Schema::dropIfExists('sessions'); // Elimina la tabla 'sessions'.
    }
};
