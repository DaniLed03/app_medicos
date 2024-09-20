<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $table = 'consultas';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'usuariomedicoid',
        'pacienteid',
        'id',
        'fechaHora',
        'talla',
        'temperatura',
        'saturacion_oxigeno',
        'frecuencia_cardiaca',
        'peso',
        'tension_arterial',
        'motivoConsulta',
        'notas_padecimiento',
        'interrogatorio_por_aparatos',
        'examen_fisico',
        'diagnostico',
        'plan',
        'status',
        'totalPagar',
        'circunferencia_cabeza',
    ];

    protected $casts = [
        'fechaHora' => 'datetime',
    ];

    public function recetas()
    {
        return $this->hasMany(ConsultaReceta::class, 'consulta_id');
    }

    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }
}
