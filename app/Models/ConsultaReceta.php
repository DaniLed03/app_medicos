<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaReceta extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'tipo_de_receta', // New field
        'receta' // New field
    ];

    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }
}