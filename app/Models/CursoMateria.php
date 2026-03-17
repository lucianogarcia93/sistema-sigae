<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoMateria extends Model
{
    use HasFactory;

    protected $table = 'curso_materia';

    public $timestamps = false;

    protected $fillable = [
        'curso_id',
        'materia_id'
    ];

    // Relación con Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relación con Materia
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
}