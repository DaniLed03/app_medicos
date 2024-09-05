<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = ['id_municipio', 'nombre', 'entidad_federativa_id'];

    public $incrementing = false;
    protected $primaryKey = ['id_municipio', 'entidad_federativa_id'];

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id', 'id');
    }
    

    public function localidades()
    {
        return $this->hasMany(Localidad::class, 'municipio_id', 'id_municipio');
    }
}

