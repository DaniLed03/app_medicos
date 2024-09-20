<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    // Declarar 'no_exp' como clave primaria
    protected $primaryKey = 'no_exp'; // Declarar 'no_exp' como clave primaria
    public $incrementing = false; // No autoincrementar
    public $keyType = 'string'; // El tipo de la clave primaria es string

    // Añadir los campos que se pueden asignar en masa
    protected $fillable = [
        'no_exp',
        'nombres',
        'apepat',
        'apemat',
        'fechanac',
        'hora',
        'peso',
        'talla',
        'lugar_naci',
        'hospital',
        'tipoparto',
        'tiposangre',
        'antecedentes',
        'padre',
        'madre',
        'entidad_federativa_id',
        'municipio_id',
        'localidad_id',
        'calle',
        'colonia_id',
        'correo',
        'telefono',
        'telefono2',
        'sexo',
        'curp',
        'activo',
        'Nombre_fact',
        'Direccion_fact',
        'RFC',
        'Regimen_fiscal',
        'CFDI',
        'medico_id'
    ];

    // Relaciones
    public function citas()
    {
        return $this->hasMany(Citas::class, 'pacienteid');
    }

    public function consultas()
    {
        return $this->hasMany(Consultas::class, 'pacienteid');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, ['no_exp', 'medico_id'], ['no_exp', 'medico_id']);
    }


    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function entidadFederativa()
    {
        return $this->belongsTo(EntidadFederativa::class, 'entidad_federativa_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id_municipio')
                    ->where('entidad_federativa_id', $this->entidad_federativa_id);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonia_id');
    }

    // Mutador para guardar el campo 'nombres' en mayúsculas
    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = strtoupper($value);
    }

    // Mutador para guardar el campo 'apepat' en mayúsculas
    public function setApepatAttribute($value)
    {
        $this->attributes['apepat'] = strtoupper($value);
    }

    // Mutador para guardar el campo 'apemat' en mayúsculas
    public function setApematAttribute($value)
    {
        $this->attributes['apemat'] = strtoupper($value);
    }

    public function setCurpAttribute($value)
    {
        $this->attributes['curp'] = strtoupper($value);
    }

    // Repite lo mismo para los demás campos
    public function setLugarNaciAttribute($value)
    {
        $this->attributes['lugar_naci'] = strtoupper($value);
    }

    public function setHospitalAttribute($value)
    {
        $this->attributes['hospital'] = strtoupper($value);
    }

    public function setPadreAttribute($value)
    {
        $this->attributes['padre'] = strtoupper($value);
    }

    public function setMadreAttribute($value)
    {
        $this->attributes['madre'] = strtoupper($value);
    }

    public function setRazonSocialAttribute($value)
    {
        $this->attributes['Nombre_fact'] = strtoupper($value);
    }

    public function setDireccionFactAttribute($value)
    {
        $this->attributes['Direccion_fact'] = strtoupper($value);
    }

    public function setRFCAttribute($value)
    {
        $this->attributes['RFC'] = strtoupper($value);
    }
    
}
