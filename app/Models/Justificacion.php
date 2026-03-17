<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justificacion extends Model
{
    use HasFactory;

    protected $table = 'justificaciones';

    protected $fillable = [
        'asistencia_alumno_id',
        'motivo',
        'estado',
        'fecha_resolucion'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    // Una justificación pertenece a una asistencia de alumno
    public function asistenciaAlumno()
    {
        return $this->belongsTo(AsistenciaAlumno::class);
    }
}