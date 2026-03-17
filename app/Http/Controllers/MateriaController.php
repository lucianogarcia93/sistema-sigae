<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Profesor;
use App\Models\Curso;
use Illuminate\Http\Request;

class MateriaController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;

        $materias = Materia::with(['profesor', 'curso'])

            ->when($search, function ($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            })

            ->latest()
            ->paginate(10);

        return view('academica.materias.index', compact('materias'));
    }



    public function create()
    {
        $profesores = Profesor::where('activo', true)->get();
        $cursos = Curso::where('activo', true)->get();

        return view('academica.materias.create', compact('profesores', 'cursos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|unique:materias,codigo',
            'profesor_id' => 'required|exists:profesores,id',
        ],[
            'codigo.unique' => 'Este código de materia ya está registrado.'
        ]);

        Materia::create($request->all());

        return redirect()
            ->route('academica.materias.index')
            ->with('success','Materia creada correctamente');
    }

    public function show(Materia $materia)
    {
        return view('academica.materias.show', compact('materia'));
    }



    public function edit(Materia $materia)
    {
        $profesores = Profesor::where('activo', true)->get();
        $cursos = Curso::where('activo', true)->get();

        return view('academica.materias.edit', compact('materia', 'profesores', 'cursos'));
    }



    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:50',
            'profesor_id' => 'required|exists:profesores,id',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $materia->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'profesor_id' => $request->profesor_id,
            'curso_id' => $request->curso_id,
        ]);

        return redirect()
            ->route('academica.materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }



    public function destroy(Materia $materia)
    {
        $materia->activo = !$materia->activo;
        $materia->save();

        return redirect()
            ->route('academica.materias.index')
            ->with('success', 'Estado de la materia actualizado.');
    }

}