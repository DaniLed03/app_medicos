<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nombres', 'apepat', 'apemat', 'sexo', 'fechanac', 'curp', 'telefono', 'correo', 'password', 'medico_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'fechanac' => 'date',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
