<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logo',
        'nombre',
        'entidad_federativa_id',
        'municipio_id',
        'localidad_id',
        'colonia_id',
        'calle',
        'telefono',
        'cedula_profesional',
        'especialidad',
        'facultad_medicina',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id', 'id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio')
                    ->where('entidad_federativa_id', $this->entidad_federativa_id);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id', 'id_localidad')
                    ->where('id_entidad_federativa', $this->entidad_federativa_id)
                    ->where('id_municipio', $this->municipio_id);
    }

    public function colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonia_id', 'id_asentamiento')
                    ->where('id_entidad', $this->entidad_federativa_id)
                    ->where('id_municipio', $this->municipio_id);
    }

}

