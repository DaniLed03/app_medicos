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
        'tipo_pago', // Tipo de pago de la venta
        'no_exp',    // Número de expediente del paciente
        'medico_id', // ID del médico relacionado con la venta
    ];

    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id', 'id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'no_exp', 'no_exp');
    }
    
    public function conceptos()
    {
        return $this->belongsToMany(Concepto::class, 'venta_conceptos', 'venta_id', 'concepto_id')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    // Relación con el modelo Paciente usando las llaves no_exp y medico_id
    public function pacienteMedico()
    {
        return $this->belongsTo(Paciente::class, ['no_exp', 'medico_id'], ['no_exp', 'medico_id']);
    }

    // Método adicional para obtener el tipo de pago con su descripción (si es necesario)
    public function getTipoPagoDescripcionAttribute()
    {
        $tiposDePago = [
            'efectivo' => 'Efectivo',
            'tarjeta' => 'Tarjeta',
            'transferencia' => 'Transferencia Bancaria',
            // Puedes agregar más tipos de pago si es necesario
        ];

        return $tiposDePago[$this->tipo_pago] ?? 'Desconocido';
    }
}
