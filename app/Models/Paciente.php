<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    
    // Los campos aqui se asignan

    protected $fillable = [
        'nombres',
        'apepat',
        'apemat',
        'fechanac',
        'activo',
    ];

    // Relación con el modelo Citas
    public function citas()
    {
        return $this->hasMany(Citas::class, 'pacienteid');
    }
}
