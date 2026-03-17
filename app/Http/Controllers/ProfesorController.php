<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $profesores = Profesor::when($request->search, function($query) use ($request){

                $query->where('nombre','like','%'.$request->search.'%')
                      ->orWhere('apellido','like','%'.$request->search.'%')
                      ->orWhere('dni','like','%'.$request->search.'%');

            })
            ->orderBy('id','desc')
            ->paginate(10);

        return view('academica.profesores.index', compact('profesores'));
    }

    public function create()
    {
        return view('academica.profesores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni'      => 'required|string|max:20|unique:profesores,dni',
            'email'    => 'nullable|email|unique:profesores,email',
        ]);

        Profesor::create([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'dni'      => $request->dni,
            'email'    => $request->email,
            'activo'   => true
        ]);

        return redirect()
            ->route('academica.profesores.index')
            ->with('success', 'Profesor creado correctamente.');
    }

    public function edit(Profesor $profesor)
    {
        return view('academica.profesores.edit', compact('profesor'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'dni'      => 'required|string|max:20|unique:profesores,dni,' . $profesor->id,
            'email'    => 'nullable|email|unique:profesores,email,' . $profesor->id,
        ]);

        $profesor->update($request->only([
            'nombre',
            'apellido',
            'dni',
            'email'
        ]));

        return redirect()
            ->route('academica.profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->activo = !$profesor->activo;
        $profesor->save();

        return redirect()
            ->route('academica.profesores.index')
            ->with('success', 'Estado actualizado correctamente.');
    }
}