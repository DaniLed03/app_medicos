<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion', // Nueva columna
        'cantidad', // Nueva columna
        'activo'
    ];

    public function consultas()
    {
        return $this->belongsToMany(Consultas::class, 'consulta_producto');
    }
}
