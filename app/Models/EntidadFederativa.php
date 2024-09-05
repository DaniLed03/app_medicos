<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadFederativa extends Model
{
    use HasFactory;

    protected $table = 'entidades_federativas';

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'entidad_federativa_id', 'id');
    }
    
}
