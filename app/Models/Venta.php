<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'precio_consulta',
        'iva',
        'total',
        'paciente_id',
        'status', 
    ];

    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    
    public function conceptos()
    {
        return $this->belongsToMany(Concepto::class, 'concepto_venta')->withPivot('cantidad')->withTimestamps();
    }
}

