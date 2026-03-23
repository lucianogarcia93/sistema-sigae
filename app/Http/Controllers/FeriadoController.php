<?php

namespace App\Http\Controllers;

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
            'fecha' => 'required|date|unique:feriados,fecha',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:feriado,sin_clases',
        ]);

        Feriado::create([
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'activo' => true
        ]);

        return redirect()
            ->route('calendario.feriados.index')
            ->with('success','Registro creado correctamente');
    }

    public function edit(Feriado $feriado)
    {
        return view('calendario.feriado.edit', compact('feriado'));
    }

    public function update(Request $request, Feriado $feriado)
    {
        $request->validate([
            'fecha' => 'required|date|unique:feriados,fecha,' . $feriado->id,
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:feriado,sin_clases',
        ]);

        $feriado->update([
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
        ]);

        return redirect()
            ->route('calendario.feriados.index')
            ->with('success','Registro actualizado correctamente');
    }

    /*
    |---------------------------------------
    | ACTIVAR / DESACTIVAR (TOGGLE)
    |---------------------------------------
    */
    public function destroy(Feriado $feriado)
    {
        $feriado->activo = !$feriado->activo;
        $feriado->save();

        return redirect()
            ->route('calendario.feriados.index')
            ->with('success','Estado actualizado correctamente');
    }

    /*
    |---------------------------------------
    | VER DÍAS (ALUMNO)
    |---------------------------------------
    */
    public function verFeriadosAlumno()
    {
        $feriados = Feriado::where('activo',1)
            ->orderBy('fecha','asc')
            ->get();

        return view('usuario_alumno.dias_feriados.feriado', compact('feriados'));
    }

    /*
    |---------------------------------------
    | NOTIFICACIONES (ALUMNO)
    |---------------------------------------
    */
    public function notificacionesAlumno()
    {
        $notificaciones = Feriado::where('activo', 1)
            ->whereDate('fecha', '>=', now()->toDateString())
            ->whereDate('fecha', '<=', now()->addDay()->toDateString())
            ->orderBy('fecha', 'asc')
            ->get();

        return view('usuario_alumno.notificaciones.notificacion', compact('notificaciones'));
    }
}