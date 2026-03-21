<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AsistenciaAlumno;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'user_id',
        'curso_id',
        'nombre',
        'apellido',
        'email',
        'dni',
        'fecha_nacimiento',
        'anio',
        'estado',
        'activo',
    ];

    // Relación con curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con calificaciones
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class); // Ajusta si tu modelo se llama distinto
    }

    // Relación con asistencias
    public function asistencias()
    {
        return $this->hasMany(AsistenciaAlumno::class); // Ajusta si tu modelo se llama distinto
    }
}