<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'hora', 'persona_id', 'medicoid', 'motivo_consulta', 'activo'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medicoid');
    }

    public function consultas()
    {
        return $this->hasMany(Consultas::class, 'citai_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
