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

    /**
     * Los atributos que se pueden llenar al crear o actualizar un usuario.
     */
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

    /**
     * Los atributos que deben ser ocultos al serializar el modelo.
     */
    protected $hidden = [
        'password',         // Ocultar la contraseña
        'remember_token',   // Ocultar el token de recordar sesión
    ];

    /**
     * Obtener los atributos que deben ser convertidos a otros tipos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Convertir a datetime
            'password' => 'hashed',           // Guardar la contraseña como hash
        ];
    }

    /**
     * Define la relación entre el modelo User y el modelo Citas.
     * Un usuario puede tener muchas citas si es médico.
     */
    public function citas()
    {
        // Relación uno a muchos: Un usuario (médico) puede tener muchas citas.
        return $this->hasMany(Citas::class, 'usuariomedicoid');
    }
}
