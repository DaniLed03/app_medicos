<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'entidad_federativa_id'];

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class);
    }

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
