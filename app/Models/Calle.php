<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'localidad_id'];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function colonias()
    {
        return $this->hasMany(Colonia::class);
    }
}
