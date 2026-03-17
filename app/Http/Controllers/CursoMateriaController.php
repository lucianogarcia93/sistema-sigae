<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Materia;

class CursoMateriaController extends Controller
{
    /**
     * Mostrar materias asignadas a un curso
     */
    public function index(Curso $curso)
    {
        $materias = Materia::where('activo', true)->get();

        $materiasAsignadas = $curso->materias->pluck('id')->toArray();

        return view('academica.cursos.materias', compact(
            'curso',
            'materias',
            'materiasAsignadas'
        ));
    }

    /**
     * Guardar materias del curso
     */
    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'materias' => 'nullable|array'
        ]);

        $curso->materias()->sync($request->materias ?? []);

        return redirect()
            ->route('academica.cursos.index')
            ->with('success', 'Materias asignadas correctamente al curso.');
    }
}