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
        'tipo_pago', // Añadir tipo_pago al fillable
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
        return $this->belongsToMany(Concepto::class, 'venta_conceptos', 'venta_id', 'concepto_id')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }




}

