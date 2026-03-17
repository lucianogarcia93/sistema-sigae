<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';
    
    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}