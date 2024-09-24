<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaReceta extends Model
{
    use HasFactory;
    protected $table = 'consulta_recetas';

    protected $fillable = [
        'consulta_id',
        'id_medico',
        'no_exp',
        'id_tiporeceta',
        'receta',
        'id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consultas::class, 'consulta_id');
    }

    public function tipoDeReceta()
    {
        return $this->belongsTo(TipoDeReceta::class, 'id_tiporeceta');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'id_medico');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'no_exp', 'no_exp');
    }
}
