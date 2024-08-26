<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
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
        'foto', // Asegúrate de que este campo esté aquí
        'medico_id',  // ID del médico asociado
        'password',   // Añadir campo de contraseña a los fillables
    ];

    protected $hidden = [
        'password',         // Ocultar la contraseña
        'remember_token',   // Ocultar el token de recordar sesión
    ];

    protected $casts = [
        'email_verified_at' => 'datetime', // Convertir a datetime
        'password' => 'hashed',           // Guardar la contraseña como hash
    ];

    public function pacientes()
    {
        return $this->hasManyThrough(Paciente::class, User::class, 'medico_id', 'medico_id', 'id', 'id');
    }

    public function consultas()
    {
        return $this->hasMany(Consultas::class, 'usuariomedicoid', 'medico_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'medico_id', 'medico_id');
    }

    public function ventas()
    {
        return $this->hasManyThrough(Venta::class, Consultas::class, 'usuariomedicoid', 'consulta_id', 'medico_id', 'id');
    }

    public function citas()
    {
        return $this->hasMany(Citas::class, 'medicoid', 'medico_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function consultorio()
    {
        return $this->hasOne(Consultorio::class);
    }

    public function getFullNameAttribute()
    {
        return "Dr. {$this->nombres} {$this->apepat} {$this->apemat}";
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('images/default-profile.png'); // Imagen por defecto si no hay foto
    }

}
