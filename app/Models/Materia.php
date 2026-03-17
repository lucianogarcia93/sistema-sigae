<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;


    protected $table = 'Materias';

    protected $fillable = [
    'nombre',
    'codigo',
    'profesor_id',
    'curso_id',
    'activo'
];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

}
