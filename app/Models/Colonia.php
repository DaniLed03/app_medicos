<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'calle_id'];

    public function calle()
    {
        return $this->belongsTo(Calle::class);
    }
}
