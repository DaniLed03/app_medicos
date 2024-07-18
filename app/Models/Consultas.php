<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'citai_id',
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
        'usuariomedicoid'
    ];

    protected $casts = [
        'fechaHora' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->fechaHora = now();
            if (is_null($model->totalPagar)) {
                $model->totalPagar = 70; // Valor por defecto
            }
        });
    }

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'citai_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }

    public function recetas()
    {
        return $this->hasMany(ConsultaReceta::class, 'consulta_id');
    }

    public function usuarioMedico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }
}
