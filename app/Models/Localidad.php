<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'municipio_id'];
    protected $table = 'localidades';

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id', 'id');
    }
}
