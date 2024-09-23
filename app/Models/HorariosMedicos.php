<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HorariosMedicos extends Model
{
    use HasFactory;

    protected $table = 'horarios_medicos';

    protected $fillable = [
        'medico_id',
        'fecha',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'duracion_sesion',
        'disponible',
        'turno',  // Asegúrate de agregar 'turno' aquí
    ];

    // Relaciones
    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    // Accesor para formatear la fecha de manera más legible
    public function getFormattedFechaAttribute()
    {
        return Carbon::parse($this->fecha)->format('d-m-Y');
    }

    // Método para verificar si una hora está dentro del horario disponible
    public function isHoraDisponible($hora)
    {
        $hora = Carbon::parse($hora);
        $inicio = Carbon::parse($this->hora_inicio);
        $fin = Carbon::parse($this->hora_fin);

        return $hora->between($inicio, $fin);
    }

    // Método para obtener los bloques de tiempo disponibles
    public function getBloquesDisponibles()
    {
        $bloques = [];
        $horaActual = Carbon::parse($this->hora_inicio);

        while ($horaActual->format('H:i') < $this->hora_fin) {
            $bloques[] = $horaActual->format('H:i');
            $horaActual->addMinutes($this->duracion_sesion);
        }

        return $bloques;
    }

    // Accesor para formatear el turno
    public function getFormattedTurnoAttribute()
    {
        switch ($this->turno) {
            case 'Matutino':
                return 'Matutino (mañana)';
            case 'Vespertino':
                return 'Vespertino (tarde)';
            case 'Nocturno':
                return 'Nocturno (noche)';
            default:
                return 'Turno no definido';
        }
    }
}
