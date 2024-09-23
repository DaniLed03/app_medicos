<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    // Aquí especificamos los campos que pueden ser llenados
    protected $fillable = [
        'fecha', 'hora', 'no_exp', 'medicoid', 'motivo_consulta', 'activo'
    ];

    // Relación con el modelo Paciente usando no_exp
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'no_exp', 'no_exp'); // Cambiado a la relación con Paciente usando no_exp
    }

    // Relación con el modelo User para el médico
    public function medico()
    {
        return $this->belongsTo(User::class, 'medicoid', 'id'); // Relación con el médico
    }

    // Relación con las consultas
    public function consultas()
    {
        return $this->hasMany(Consultas::class, 'citai_id');
    }
}
