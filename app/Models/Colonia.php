<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser asignados en masa (mass assignment)
    protected $fillable = [
        'asentamiento',      // Campo para el nombre del asentamiento
        'id_entidad',        // ID de la entidad federativa
        'id_municipio',      // ID del municipio
        'cp',                // Código postal
        'tipo_asentamiento'  // Tipo de asentamiento (Colonia, Fraccionamiento, etc.)
    ];

    // Relaciones

    // Si una colonia pertenece a una entidad federativa
    public function entidad()
    {
        return $this->belongsTo(EntidadFederativa::class, 'id_entidad');
    }

    // Si una colonia pertenece a un municipio
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio');
    }
}
