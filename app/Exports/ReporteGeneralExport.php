<?php

namespace App\Exports;

use App\Models\Alumno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteGeneralExport implements FromCollection, WithHeadings
{
    protected $curso_id;
    protected $turno;
    protected $anio;

    public function __construct($curso_id, $turno, $anio)
    {
        $this->curso_id = $curso_id;
        $this->turno = $turno;
        $this->anio = $anio;
    }

    public function collection()
    {
        $query = Alumno::with('curso.nivel');

        if ($this->curso_id) {
            $query->where('curso_id', $this->curso_id);
        }

        if ($this->anio) {
            $query->where('anio', $this->anio);
        }

        if ($this->turno) {
            $query->whereHas('curso', function($q) {
                $q->where('turno', $this->turno);
            });
        }

        return $query->get()->map(function($alumno) {
            return [
                'ID' => $alumno->id,
                'Nombre' => $alumno->nombre,
                'Apellido' => $alumno->apellido,
                'DNI' => $alumno->dni,
                'Nivel' => $alumno->curso->nivel->nombre ?? '-',
                'Curso' => $alumno->curso->division ?? '-',
                'Estado' => $alumno->activo ? 'Activo' : 'Inactivo', // 🔥 CAMBIO
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Apellido',
            'DNI',
            'Nivel',
            'Curso',
            'Estado Alumno',
        ];
    }
}