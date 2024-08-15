<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'inventario',
        'precio', // Agregar precio
        'medico_id',
    ];

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'producto_venta')->withPivot('cantidad')->withTimestamps();
    }
}
