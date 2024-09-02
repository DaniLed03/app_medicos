<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaConcepto extends Model
{
    use HasFactory;

    protected $table = 'venta_conceptos'; // Especifica el nombre de la tabla

    protected $fillable = [
        'venta_id',
        'concepto_id',
        'cantidad',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }
}
