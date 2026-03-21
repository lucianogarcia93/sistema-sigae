<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\CursoMateria;
use App\Models\Calificacion;

class CalificacionController extends Controller
{
    /**
     * Mostrar pantalla principal
     */
    public function index(Request $request)
    {
        $cursos = Curso::with('nivel')
        ->where('activo', 1) //solo cursos activos
        ->get();
        $cursoSeleccionado = null;
        $alumnos = [];
        $materiasCurso = [];
        $notasExistentes = [];
        $tipoSeleccionado = $request->tipo_nota ?? '';

        if ($request->curso_id) {
            $cursoSeleccionado = Curso::with('nivel')->find($request->curso_id);
            if ($cursoSeleccionado) {

                // 🔥 FILTRO POR AÑO
                if ($request->filled('anio')) {
                    $alumnos = Alumno::where('curso_id', $request->curso_id)
                        ->where('anio', $request->anio)
                        ->get();
                }

                $materiasCurso = CursoMateria::with('materia')
                    ->where('curso_id', $request->curso_id)
                    ->get();

                if ($request->materia_curso_id && $request->tipo_nota && $request->filled('anio')) {

                    $notasExistentes = Calificacion::whereIn('alumno_id', $alumnos->pluck('id'))
                        ->where('materia_curso_id', $request->materia_curso_id)
                        ->where('tipo', $request->tipo_nota) // ✅ corregido
                        ->where('anio', $request->anio) // 🔥 clave
                        ->get()
                        ->keyBy(function ($item) {
                            return $item->alumno_id . '_' . $item->tipo;
                        });
                }
            }
        }

        return view('calendario.calificaciones.index', compact(
            'cursos',
            'cursoSeleccionado',
            'alumnos',
            'materiasCurso',
            'notasExistentes',
            'tipoSeleccionado'
        ));
    }

    /**
     * Guardar calificaciones
     */
    public function store(Request $request)
    {
        // ✅ Validación básica
        $request->validate([
            'materia_curso_id' => 'required|exists:curso_materia,id',
            'tipo_nota' => 'required|string',
            'anio' => 'required|integer', // 🔹 validar que venga año
            'notas' => 'required|array',
            'notas.*' => 'nullable|numeric|min:0|max:10'
        ]);

        $tipo = $request->tipo_nota;

        // 🔥 VALIDACIÓN: todos los alumnos deben tener nota
        foreach ($request->notas as $alumno_id => $nota) {
            if ($nota === null || $nota === '') {
                return back()->with('error', 'Debe ingresar una nota para todos los alumnos antes de guardar.');
            }
        }

        // 🔹 Guardar o actualizar notas
        foreach ($request->notas as $alumno_id => $nota) {
            Calificacion::updateOrCreate(
                [
                    'alumno_id' => $alumno_id,
                    'materia_curso_id' => $request->materia_curso_id,
                    'tipo' => $tipo,
                    'anio' => $request->anio // 🔹 obligatorio y clave
                ],
                [
                    'nota' => $nota,
                    'fecha' => now()
                ]
            );
        }

        // 🔹 Redirigir manteniendo filtros
        $redirectData = [
            'curso_id' => $request->curso_id,
            'materia_curso_id' => $request->materia_curso_id,
            'tipo_nota' => $request->tipo_nota,
            'anio' => $request->anio
        ];

        return redirect()->route('calendario.calificaciones.index')
            ->with('success', 'Notas guardadas correctamente');
    }
    /**
     * Mostrar detalle (boletín)
     */
    public function show($id)
    {
        $calificacion = Calificacion::with([
            'alumno',
            'materiaCurso.materia',
            'materiaCurso.curso'
        ])->findOrFail($id);

        return view('calendario.calificaciones.show', compact('calificacion'));
    }

    /**
     * Editar
     */
    public function edit($id)
    {
        $calificacion = Calificacion::findOrFail($id);

        return view('calendario.calificaciones.edit', compact('calificacion'));
    }

    /**
     * Actualizar
     */
    public function update(Request $request, $id)
    {
        $calificacion = Calificacion::findOrFail($id);

        $request->validate([
            'nota' => 'required|numeric|min:0|max:10',
            'tipo' => 'nullable|string'
        ]);

        $calificacion->update([
            'nota' => $request->nota,
            'tipo' => $request->tipo,
            'fecha' => now()
        ]);

        return back()->with('success', 'Nota actualizada');
    }

    /**
     * Eliminar
     */
    public function destroy($id)
    {
        $calificacion = Calificacion::findOrFail($id);
        $calificacion->delete();

        return back()->with('success', 'Nota eliminada');
    }

    public function misNotas()
    {
        $alumno = auth()->user()->alumno;

        $notas = Calificacion::with(['materiaCurso.materia'])
            ->where('alumno_id', $alumno->id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('usuario_alumno.mis_notas.nota', compact('notas'));
    }
}