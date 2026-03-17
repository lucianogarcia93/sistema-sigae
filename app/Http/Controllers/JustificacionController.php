<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Justificacion;
use App\Models\AsistenciaAlumno;
use Illuminate\Support\Facades\Auth;

class JustificacionController extends Controller
{
    /*
    |------------------------------------------------
    | LISTADO JUSTIFICACIONES ALUMNO
    |------------------------------------------------
    */
    public function index()
    {
        if (!auth()->check() || optional(auth()->user()->role)->name !== 'alumno') {
            abort(403);
        }

        $alumno = auth()->user()->alumno;

        if (!$alumno) {
            abort(403);
        }

        $justificaciones = Justificacion::with('asistenciaAlumno')
            ->whereHas('asistenciaAlumno', function ($q) use ($alumno) {
                $q->where('alumno_id', $alumno->id);
            })
            ->orderByDesc('updated_at') // 🔥 esto es lo importante
            ->get();

        return view('usuario_alumno.justificacion.index', compact('justificaciones'));
    }
    /*
    |------------------------------------------------
    | LISTADO ADMIN
    |------------------------------------------------
    */
    public function indexAdmin()
    {
        if (optional(auth()->user()->role)->name !== 'admin') {
            abort(403);
        }

        $justificaciones = Justificacion::with([
            'asistenciaAlumno.alumno'
        ])
        ->latest()
        ->get();

        return view('calendario.justificaciones.index', compact('justificaciones'));
    }

    /*
    |------------------------------------------------
    | FORMULARIO ALUMNO
    |------------------------------------------------
    */
    public function create()
    {
        if (optional(auth()->user()->role)->name !== 'alumno') {
            abort(403);
        }

        $alumno = auth()->user()->alumno;

        if (!$alumno) {
            abort(403);
        }

        $ausentes = AsistenciaAlumno::where('alumno_id', $alumno->id)
            ->where('estado', 'ausente')
            ->doesntHave('justificacion')
            ->orderByDesc('fecha')
            ->get();

        return view('usuario_alumno.justificacion.motivo', compact('ausentes'));
    }

    /*
    |------------------------------------------------
    | GUARDAR JUSTIFICACION ALUMNO
    |------------------------------------------------
    */
    public function store(Request $request)
    {
        if (optional(auth()->user()->role)->name !== 'alumno') {
            abort(403);
        }

        $alumno = auth()->user()->alumno;

        if (!$alumno) {
            abort(403);
        }

        $request->validate([
            'asistencia_alumno_id' =>
                'required|exists:asistencia_alumnos,id|unique:justificaciones,asistencia_alumno_id',

            'motivo' => 'required|string|min:10'
        ]);

        Justificacion::create([
            'asistencia_alumno_id' => $request->asistencia_alumno_id,
            'motivo' => $request->motivo,
            'estado' => 'pendiente'
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Justificación enviada correctamente');
    }

    /*
    |------------------------------------------------
    | APROBAR / RECHAZAR ADMIN
    |------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        if (optional(auth()->user()->role)->name !== 'admin') {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:aprobado,rechazado'
        ]);

        $justificacion = Justificacion::findOrFail($id);

        if ($justificacion->estado !== 'pendiente') {
            return back()->with('error', 'Esta justificación ya fue procesada.');
        }

        $estadoFinal = $request->estado === 'aprobado'
            ? 'aprobado'
            : 'rechazado';

        $justificacion->update([
            'estado' => $estadoFinal,
            'fecha_resolucion' => now()
        ]);

        if ($estadoFinal === 'aprobado') {
            AsistenciaAlumno::where(
                'id',
                $justificacion->asistencia_alumno_id
            )->update([
                'estado' => 'justificado'
            ]);
        }

        return back()->with('success', 'Estado actualizado correctamente');
    }
}