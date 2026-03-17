<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsistenciaAlumno;
use App\Models\Alumno;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REPORTES GENERALES (GRÁFICO)
    |--------------------------------------------------------------------------
    */

    public function generales(Request $request)
    {
        $fechas = AsistenciaAlumno::select('fecha')
                    ->distinct()
                    ->orderBy('fecha', 'desc')
                    ->pluck('fecha');

        $fechaSeleccionada = $request->fecha ?? $fechas->first();

        if ($fechaSeleccionada) {

            $presentes = AsistenciaAlumno::whereDate('fecha', $fechaSeleccionada)
                            ->where('estado', 'presente')
                            ->count();

            $ausentes = AsistenciaAlumno::whereDate('fecha', $fechaSeleccionada)
                            ->where('estado', 'ausente')
                            ->count();

            $total = $presentes + $ausentes;

        } else {

            $presentes = 0;
            $ausentes = 0;
            $total = 0;
        }

        $porcentaje = $total > 0
            ? round(($presentes / $total) * 100)
            : 0;

        return view('reportes.generales', compact(
            'fechas',
            'fechaSeleccionada',
            'total',
            'presentes',
            'ausentes',
            'porcentaje'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PDF LISTADO DE ALUMNOS (VERSIÓN SIMPLE)
    |--------------------------------------------------------------------------
    */

    public function alumnosPdf()
    {
        $alumnos = Alumno::with('curso.nivel')
            ->where('activo',1)
            ->orderBy('apellido')
            ->get();

        $pdf = Pdf::loadView('reportes.pdf.alumnos', compact('alumnos'));

        return $pdf->stream('lista_alumnos.pdf');
    }

}