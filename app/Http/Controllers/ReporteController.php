<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsistenciaAlumno;
use App\Models\Alumno;
use App\Models\Curso;
use Barryvdh\DomPDF\Facade\Pdf;

// 👉 EXCEL
use App\Exports\ReporteGeneralExport;
use Maatwebsite\Excel\Facades\Excel;


class ReporteController extends Controller
{
    public function generales(Request $request)
    {
        // 🔹 Fechas (compatibilidad)
        $fechas = AsistenciaAlumno::select('fecha')
                    ->distinct()
                    ->orderBy('fecha', 'asc')
                    ->pluck('fecha');

        // 🔹 Filtros
        $cursoId = $request->curso_id;
        $anio = $request->anio;

        // 🔹 Inicializamos cards
        $total = $presentes = $ausentes = $porcentaje = 0;
        $datasetsGrafico = [];
        $fechasGrafico = [];

        if ($cursoId && $anio) { // 🔹 Solo calculamos si ambos filtros existen

            // 🔹 Query base
            $query = AsistenciaAlumno::with('alumno')
                        ->whereHas('alumno', function ($q) use ($cursoId, $anio) {
                            $q->where('curso_id', $cursoId)
                            ->where('anio', $anio)
                            ->where('activo', true);
                        });

            // 🔹 Cards
            $presentes = (clone $query)->where('estado', 'presente')->count();
            $ausentes = (clone $query)->where('estado', 'ausente')->count();
            $total = $presentes + $ausentes;
            $porcentaje = $total > 0 ? round(($presentes / $total) * 100) : 0;

            // ------------------------------------------------------------------
            // 🔥 GRÁFICO DE ONDAS
            // ------------------------------------------------------------------

            // 🔹 Fechas reales
            $fechasOriginales = AsistenciaAlumno::whereHas('alumno', function ($q) use ($cursoId, $anio) {
                    $q->where('curso_id', $cursoId)
                    ->where('anio', $anio)
                    ->where('activo', true);
                })
                ->orderBy('fecha', 'asc')
                ->pluck('fecha')
                ->unique()
                ->values();

            // 🔥 Labels EXPANDIDAS (para suavizar onda)
            $fechasGrafico = $fechasOriginales->flatMap(function ($f) {
                $label = \Carbon\Carbon::parse($f)->format('d/m');
                return [$label, '', '', ''];
            });

            // 🔹 Alumnos
            $alumnos = Alumno::where('curso_id', $cursoId)
                            ->where('anio', $anio)
                            ->where('activo', true)
                            ->take(5)
                            ->get();

            foreach ($alumnos as $alumno) {

                $data = [];

                foreach ($fechasOriginales as $fecha) {
                    $asistencia = AsistenciaAlumno::where('alumno_id', $alumno->id)
                                    ->whereDate('fecha', $fecha)
                                    ->first();

                    $valor = ($asistencia && $asistencia->estado == 'presente')
                        ? rand(6,10)
                        : -rand(3,7);

                    $data[] = $valor;
                    $data[] = $valor * 0.6;
                    $data[] = 0;
                    $data[] = $valor * -0.6;
                }

                $datasetsGrafico[] = [
                    'label' => $alumno->nombre,
                    'data' => $data,
                    'borderWidth' => 2,
                    'fill' => false,
                ];
            }
        }

        // 🔹 Cursos
        $cursos = Curso::with('nivel')
            ->where('activo', 1)
            ->get();

        return view('reportes.generales', compact(
            'fechas',
            'total',
            'presentes',
            'ausentes',
            'porcentaje',
            'cursos',
            'fechasGrafico',
            'datasetsGrafico'
        ));
    }
    /*
    |-----------------------------------------------------------------------
    | VISTA PARA SELECCIONAR CURSO + TURNO Y DESCARGAR EXCEL
    |-----------------------------------------------------------------------
    */
    public function index()
    {
        $cursos = Curso::where('activo', true)->with('nivel')->get(); 
        return view('reportes.excel', compact('cursos'));
    }

    /*
    |-----------------------------------------------------------------------
    | EXPORTAR EXCEL (DESPUÉS DE SELECCIONAR CURSO + TURNO)
    |-----------------------------------------------------------------------
    */
    public function export(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'turno'    => 'required|string',
            'anio'     => 'required|integer',
        ]);

        // Filtrar alumnos por curso, año y turno (turno desde cursos)
        $alumnos = Alumno::where('curso_id', $request->curso_id)
                        ->where('anio', $request->anio)
                        ->whereHas('curso', function($q) use ($request) {
                            $q->where('turno', $request->turno);
                        })
                        ->get();

        if ($alumnos->isEmpty()) {
            return back()->with('error', 'No se encontraron alumnos para el año, curso y turno seleccionado.');
        }

        // Pasamos la colección de alumnos filtrados al export
        return Excel::download(
            new ReporteGeneralExport($request->curso_id, $request->turno, $request->anio),
            'reporte_general.xlsx'
        );
    }

    /*
    |-----------------------------------------------------------------------
    | NUEVOS MÉTODOS: ESTADÍSTICAS POR ALUMNO
    |-----------------------------------------------------------------------
    */

    // Mostrar formulario y resultados de un alumno
    public function estadistica(Request $request)
    {
        $cursos = Curso::with('nivel')
        ->where('activo', 1) //solo cursos activos
        ->get();
        
        $alumnos = [];
        $alumno = null;
        $totalAsistencias = 0;
        $totalFaltas = 0;
        $calificaciones = [];

        // 🔹 Filtrar alumnos por curso + año
        if ($request->filled('curso_id') && $request->filled('anio')) {
            $alumnos = Alumno::where('curso_id', $request->curso_id)
                            ->where('anio', $request->anio) // ✅ agregado
                            ->where('activo', 1)
                            ->orderBy('apellido')
                            ->get();
        }

        // 🔹 Buscar alumno seleccionado
        if ($request->filled('alumno_id') && $request->filled('curso_id')) {
            $alumno = Alumno::with(['calificaciones.materia','asistencias'])
                            ->where('id', $request->alumno_id)
                            ->where('curso_id', $request->curso_id)
                            ->first();

            if ($alumno) {
                $totalAsistencias = $alumno->asistencias()->where('estado','presente')->count();
                $totalFaltas = $alumno->asistencias()->where('estado','ausente')->count();
                $calificaciones = $alumno->calificaciones;
            }
        }

        return view('reportes.pdf.estadisticas', compact(
            'cursos','alumnos','alumno','totalAsistencias','totalFaltas','calificaciones'
        ));
    }

    // Generar PDF del alumno seleccionado
    public function estadisticaPdf(Request $request)
    {
        $curso_id = $request->curso_id;
        $alumno_id = $request->alumno_id;
        $anio = $request->anio; // ✅ agregado

        $alumno = Alumno::with(['calificaciones.materiaCurso.materia','asistencias'])
                        ->where('id', $alumno_id)
                        ->where('curso_id', $curso_id)
                        ->where('anio', $anio) // ✅ agregado
                        ->firstOrFail();

        $totalAsistencias = $alumno->asistencias()
                            ->where('estado','presente')
                            ->count();

        $totalFaltas = $alumno->asistencias()
                            ->where('estado','ausente')
                            ->count();

        $calificaciones = $alumno->calificaciones;

        $pdf = Pdf::loadView('reportes.pdf.alumnos', compact(
            'alumno','totalAsistencias','totalFaltas','calificaciones'
        ));

        return $pdf->stream('estadisticas_alumno.pdf');
    }

        /*
    |-----------------------------------------------------------------------
    | PDF LISTADO DE ALUMNOS
    |-----------------------------------------------------------------------
    */
    public function alumnosPdf()
    {
        $alumnos = Alumno::with('curso.nivel')
            ->where('activo', 1)
            ->orderBy('apellido')
            ->get();

        $pdf = Pdf::loadView('reportes.pdf.alumnos', compact('alumnos'));

        return $pdf->stream('lista_alumnos.pdf');
    }
}