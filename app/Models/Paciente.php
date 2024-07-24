<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'no_exp',
        'nombres',
        'apepat',
        'apemat',
        'fechanac',
        'hora',
        'peso',
        'talla',
        'lugar_naci',
        'hospital',
        'tipoparto',
        'tiposangre',
        'antecedentes',
        'padre',
        'madre',
        'direccion',
        'correo',
        'telefono',
        'telefono2',
        'sexo',
        'curp', // Add this line
        'activo',
    ];

    public function citas()
    {
        return $this->hasMany(Citas::class, 'pacienteid');
    }
}
