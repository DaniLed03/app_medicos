<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Clase User que representa a un usuario en el sistema.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nombres',    // Nombres del usuario
        'apepat',     // Apellido paterno del usuario
        'apemat',     // Apellido materno del usuario
        'fechanac',   // Fecha de nacimiento del usuario
        'telefono',   // Teléfono del usuario
        'sexo',
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

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'medico_id');
    }

    public function getFullNameAttribute()
    {
        return "Dr. {$this->nombres} {$this->apepat} {$this->apemat}";
    }
}
