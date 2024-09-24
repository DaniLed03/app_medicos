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
        'circunferencia_cabeza',
        'años',   // Nuevo campo
        'meses',  // Nuevo campo
        'dias',   // Nuevo campo
        'motivoConsulta',
        'diagnostico',
        'status',
        'totalPagar',
    ];

    protected $casts = [
        'fechaHora' => 'datetime',
    ];

    // Relación con la tabla consulta_recetas filtrando por id_medico y no_exp
    public function recetas()
    {
        return $this->hasMany(ConsultaReceta::class, 'consulta_id');
    }

    public function recetasPorPaciente($pacienteId)
    {
        return $this->hasMany(ConsultaReceta::class, 'consulta_id')
                    ->where('no_exp', $pacienteId)
                    ->where('id_medico', $this->usuariomedicoid);  // Filtra por el ID del médico
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
