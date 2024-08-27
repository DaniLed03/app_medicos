<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_exp',
        'nombres',
        'apepat',
        'apemat',
        'fechanac',
        'hora',
        'peso',
        'talla',
        'lugar_naci',
        'hospital',
        'tipoparto',
        'tiposangre',
        'antecedentes',
        'padre',
        'madre',
        'entidad_federativa_id',
        'municipio_id',
        'localidad_id',
        'calle',  // Cambiado de `calle_id` a `calle` como string
        'colonia_id',
        'correo',
        'telefono',
        'telefono2',
        'sexo',
        'curp',
        'activo',
        'Nombre_fact',
        'Direccion_fact',
        'RFC',
        'Regimen_fiscal',
        'CFDI',
        'medico_id'
    ];

    public function citas()
    {
        return $this->hasMany(Citas::class, 'pacienteid');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio')->where('entidad_federativa_id', $this->entidad_federativa_id);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonia_id');
    }

}

