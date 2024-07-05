<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'activo',
        'pacienteid',
        'medicoid'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medicoid');
    }

    public function consultas()
    {
        return $this->hasMany(Consultas::class, 'citai_id');
    }
}

