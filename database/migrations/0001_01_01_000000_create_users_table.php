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
            $table->id();
            $table->string('nombres', 100);
            $table->string('apepat', 100);
            $table->string('apemat', 100);
            $table->date('fechanac');
            $table->string('telefono', 20);
            $table->enum('rol', ['medico', 'secretaria', 'colaborador', 'admin', 'enfermera']);
            $table->enum('sexo', ['masculino', 'femenino']); 
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
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
