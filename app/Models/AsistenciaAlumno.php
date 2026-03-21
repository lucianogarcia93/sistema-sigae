<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaAlumno extends Model
{
    use HasFactory;

    protected $table = 'asistencia_alumnos';

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'fecha',
        'estado',
        'anio'
    ];

    public function justificacion()
    {
        return $this->hasOne(Justificacion::class, 'asistencia_alumno_id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}