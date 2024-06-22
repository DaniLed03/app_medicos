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
        'diagnostico',
        'recete',
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
        });
    }

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'citai_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto');
    }
}
