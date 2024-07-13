<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Clase User que representa a un usuario en el sistema.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombres',    // Nombres del usuario
        'apepat',     // Apellido paterno del usuario
        'apemat',     // Apellido materno del usuario
        'fechanac',   // Fecha de nacimiento del usuario
        'telefono',   // Teléfono del usuario
        'rol',        // Rol del usuario (ej. admin, doctor, paciente)
        'activo',     // Estado del usuario (activo o inactivo)
        'email',      // Correo electrónico del usuario
        'password',   // Contraseña del usuario
    ];

    protected $hidden = [
        'password',         // Ocultar la contraseña
        'remember_token',   // Ocultar el token de recordar sesión
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convertir a datetime
            'password' => 'hashed',           // Guardar la contraseña como hash
        ];
    }

    public function citas()
    {
        return $this->hasMany(Citas::class, 'usuariomedicoid');
    }

    public function getFullNameAttribute()
    {
        return "Dr. {$this->nombres} {$this->apepat} {$this->apemat}";
    }
}
