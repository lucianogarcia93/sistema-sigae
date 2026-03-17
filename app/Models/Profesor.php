<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email'
    ];

    protected $dates = ['deleted_at'];
}