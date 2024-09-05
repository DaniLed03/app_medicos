<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    public $incrementing = false;  // Desactivamos el auto-incremento
    protected $keyType = 'string'; // Definimos que la clave primaria no será un número entero

    // Definimos los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_asentamiento', 
        'id_entidad', 
        'id_municipio', 
        'cp', 
        'asentamiento', 
        'tipo_asentamiento'
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }
    
    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'id_entidad', 'id');
    }
}
