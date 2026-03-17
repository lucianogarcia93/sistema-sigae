<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}