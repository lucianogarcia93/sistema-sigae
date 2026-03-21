<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Nivel;
use App\Models\Alumno;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::with('nivel','materias')
            ->when($request->search, function ($query) use ($request) {

                $query->where('division', 'like', '%' . $request->search . '%')
                    ->orWhere('turno', 'like', '%' . $request->search . '%')
                    ->orWhereHas('nivel', function ($q) use ($request) {
                        $q->where('nombre', 'like', '%' . $request->search . '%');
                    });

            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('academica.cursos.index', compact('cursos'));
    }
    public function create()
    {
        $niveles = Nivel::where('activo', true)->get();

        return view('academica.cursos.create', compact('niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nivel_id' => 'required|exists:niveles,id',
            'division' => [
                'required',
                'string',
                'max:10',
                Rule::unique('cursos')->where(function ($query) use ($request) {
                    return $query->where('nivel_id', $request->nivel_id);
                }),
            ],
            'turno' => 'nullable|string|max:50',
        ]);

        Curso::create([
            'nivel_id' => $request->nivel_id,
            'division' => strtoupper($request->division),
            'turno' => $request->turno,
            'activo' => true,
        ]);

        return redirect()->route('academica.cursos.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        $niveles = Nivel::where('activo', true)->get();

        return view('academica.cursos.edit', compact('curso', 'niveles'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nivel_id' => 'required|exists:niveles,id',
            'division' => 'required|string|max:10',
            'turno' => 'nullable|string|max:50',
        ]);

        $curso->update([
            'nivel_id' => $request->nivel_id,
            'division' => strtoupper($request->division),
            'turno' => $request->turno,
        ]);

        return redirect()->route('academica.cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->activo = !$curso->activo;
        $curso->save();

        Alumno::where('curso_id', $curso->id)
            ->update([
                'activo' => $curso->activo
            ]);

        return redirect()->route('academica.cursos.index')
            ->with('success', 'Estado del curso actualizado correctamente.');
    }

    public function qr(Curso $curso)
    {
        return view('academica.cursos.codigo', compact('curso'));
    }

    public function formInscripcion(Curso $curso)
    {
        return view('inscripciones.formulario', compact('curso'));
    }

    public function storeInscripcion(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:solicitudes,dni',
            'email' => 'required|email|max:255|unique:solicitudes,email',
            'anio' => 'required|integer',
        ]);

        // Crear solicitud en lugar de alumno
        Solicitud::create([
            'curso_id' => $curso->id,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'email' => $request->email,
            'anio' => $request->anio,
            'estado' => 'pendiente',  // Pendiente de aprobación
        ]);

        return redirect()->route('academica.cursos.inscripcion.form', $curso)
            ->with('success', 'Su solicitud de inscripción ha sido enviada y está pendiente de aprobación por el administrador.');
    }

}