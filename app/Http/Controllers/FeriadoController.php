<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    public function index()
    {
        $feriados = Feriado::orderBy('fecha','desc')->get();

        return view('calendario.feriado.index', compact('feriados'));
    }

    public function create()
    {
        return view('calendario.feriado.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        Feriado::create([
            'fecha' => $request->fecha,
            'nombre' => $request->nombre,
            'activo' => $request->has('activo') ? 1 : 0
        ]);

        return redirect()
            ->route('calendario.feriados.index')
            ->with('success','Feriado creado correctamente');
    }

    public function edit($id)
    {
        $feriado = Feriado::findOrFail($id);

        return view('calendario.feriado.edit', compact('feriado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'nombre' => 'required|string|max:255',
            'activo' => 'required|boolean'
        ]);

        $feriado = Feriado::findOrFail($id);

        $feriado->update([
            'fecha' => $request->fecha,
            'nombre' => $request->nombre,
            'activo' => $request->activo
        ]);

        return redirect()
            ->route('calendario.feriados.index')
            ->with('success','Feriado actualizado correctamente');
    }

    /*
    |---------------------------------------
    | VER FERIADOS (ALUMNO)
    |---------------------------------------
    */
    
    public function verFeriadosAlumno()
    {
        $feriados = Feriado::where('activo',1)
            ->orderBy('fecha','asc')
            ->get();

        return view('usuario_alumno.dias_feriados.feriado', compact('feriados'));
    }
}