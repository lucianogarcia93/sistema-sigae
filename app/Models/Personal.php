<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'sector_id',
        'nombre',
        'apellido',
        'dni',
        'cargo',
        'telefono',
        'email',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR OPCIONAL (nombre completo)
    |--------------------------------------------------------------------------
    */

    public function getNombreCompletoAttribute()
    {
        return $this->apellido . ', ' . $this->nombre;
    }
}