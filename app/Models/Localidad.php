<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $fillable = ['localidades', 'municipio_id'];
    protected $table = 'localidades';

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function calles()
    {
        return $this->hasMany(Calle::class);
    }
}
