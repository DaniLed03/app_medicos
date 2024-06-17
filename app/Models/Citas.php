<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    // Los campos aqui se asignan
    protected $fillable = [
        'fecha',
        'hora',
        'activo',
        'pacienteid',
        'usuariomedicoid'
    ];

    // Relación con el modelo Paciente
    // Una cita pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    // Relación con el modelo User (medico)
    // Una cita pertenece a un médico usuario
    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }
}
