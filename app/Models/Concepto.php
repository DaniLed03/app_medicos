<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $table = 'conceptos';
    protected $primaryKey = 'id_concepto';
    public $incrementing = false; // Cambiar a false
    public $timestamps = true;

    protected $fillable = [
        'id_concepto',  // Asegúrate de incluirlo en fillable
        'concepto',
        'precio_unitario',
        'impuesto',
        'unidad_medida',
        'tipo_concepto',
        'medico_id',
    ];

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_conceptos')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}



