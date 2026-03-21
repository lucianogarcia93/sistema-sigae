<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'alumno_id',
        'materia_curso_id',
        'nota',
        'tipo',
        'fecha',
        'anio'
    ];

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    // Relación con materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Relación con CursoMateria
     */
    public function materiaCurso()
    {
        return $this->belongsTo(CursoMateria::class, 'materia_curso_id');
    }
}