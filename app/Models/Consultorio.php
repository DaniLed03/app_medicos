<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logo',
        'nombre',
        'entidad_federativa',
        'municipio',
        'localidad',
        'calle',
        'colonia',
        'telefono',
        'cedula_profesional',
        'especialidad',
        'facultad_medicina',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
