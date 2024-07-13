<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Paciente que representa el modelo de un paciente en el sistema.
 */
class Paciente extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombres',    // Nombres del paciente
        'apepat',     // Apellido paterno del paciente
        'apemat',     // Apellido materno del paciente
        'fechanac',   // Fecha de nacimiento del paciente
        'correo',     // Correo del paciente
        'contraseña', // Contraseña del paciente
        'telefono',   // Teléfono del paciente
        'sexo',       // Sexo del paciente
        'activo',     // Estado del paciente (activo o inactivo)
    ];

    /**
     * Define la relación entre el modelo Paciente y el modelo Citas.
     * Un paciente puede tener muchas citas.  
     */
    public function citas()
    {
        // Relación uno a muchos: Un paciente puede tener muchas citas.
        return $this->hasMany(Citas::class, 'pacienteid');
    }
}
