<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'nivel_id',
        'division',
        'turno',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'curso_materia');
    }
}