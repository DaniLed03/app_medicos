<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeReceta extends Model
{
    use HasFactory;

    protected $table = 'tipo_de_receta'; // Especifica la tabla

    protected $primaryKey = 'id'; 
    public $incrementing = true; 
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
    ];

    public function recetas()
    {
        return $this->hasMany(ConsultaReceta::class, 'id_tiporeceta');
    }
}
