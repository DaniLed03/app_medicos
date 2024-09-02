<?php

// Colonia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    protected $primaryKey = ['id_asentamiento', 'id_entidad', 'id_municipio'];
    public $incrementing = false;
    protected $keyType = 'array';

    // Definir los campos que pueden ser asignados en masa (mass assignment)
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

    public function entidad()
    {
        return $this->belongsTo(EntidadFederativa::class, 'id_entidad', 'id');
    }
}
