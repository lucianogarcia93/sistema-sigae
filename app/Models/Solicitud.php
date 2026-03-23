<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'curso_id',
        'nombre',
        'apellido',
        'dni',
        'email',
        'anio',
        'fecha_nacimiento',
        'estado',
        'token',           // 🔥 IMPORTANTE
        'motivo_rechazo',  // 🔥 IMPORTANTE
        'password_temporal' // 🔥 NUEVO: contraseña que verá el alumno
    ];

    // Relación con Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}