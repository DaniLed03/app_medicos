<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $table = 'conceptos';
    protected $primaryKey = 'id_concepto';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'concepto',
        'precio_unitario',
        'impuesto',
        'unidad_medida',
        'tipo_concepto',
        'medico_id',
    ];

    // Relación con el modelo User
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    // Relación con el modelo Venta
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_conceptos')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }



}

