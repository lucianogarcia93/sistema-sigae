<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\User;
use App\Models\Role;
use App\Models\AsistenciaAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AlumnoController extends Controller
{
    // INDEX: solo alumnos aprobados
    public function index(Request $request)
    {
        $alumnos = Alumno::with('curso.nivel')
            ->where('estado', 'aprobado') // mostrar solo aprobados
            ->when($request->search, function($query) use ($request){
                $query->where('nombre','like','%'.$request->search.'%')
                      ->orWhere('apellido','like','%'.$request->search.'%')
                      ->orWhere('dni','like','%'.$request->search.'%');
            })
            ->orderBy('id','desc')
            ->paginate(10);

        return view('academica.alumnos.index', compact('alumnos'));
    }

    // CREATE
    public function create()
    {
        $cursos = Curso::with('nivel')->where('activo', true)->get();
        return view('academica.alumnos.create', compact('cursos'));
    }

    // STORE (solicitud pendiente)
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'required|email|unique:alumnos,email',
            'dni'      => 'required|string|unique:alumnos,dni',
            'fecha_nacimiento' => 'nullable|date',
            'anio' => 'required|integer|min:2026'
        ]);

        Alumno::create([
            'curso_id' => $request->curso_id,
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
            'dni'      => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'anio'     => $request->anio,
            'estado'   => 'pendiente',
            'activo'   => false
        ]);

        return back()->with('success','Su solicitud de inscripción ha sido enviada y está pendiente de aprobación por el administrador.');
    }

    // EDIT
    public function edit(Alumno $alumno)
    {
        $cursos = Curso::with('nivel')->where('activo', true)->get();
        return view('academica.alumnos.edit', compact('alumno','cursos'));
    }

    // UPDATE
    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'nombre'   => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email'    => 'nullable|email|max:150|unique:users,email,' . $alumno->user_id,
            'dni'      => 'required|string|unique:alumnos,dni,' . $alumno->id,
            'fecha_nacimiento' => 'nullable|date',
            'anio' => 'required|integer|min:2026'
        ]);

        $alumno->update([
            'curso_id' => $request->curso_id,
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
            'dni'      => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'anio' => $request->anio
        ]);

        if($alumno->user){
            $alumno->user->update([
                'name' => $request->nombre.' '.$request->apellido,
                'email' => $request->email,
                'dni' => $request->dni
            ]);
        }

        return redirect()->route('academica.alumnos.index')->with('success','Alumno actualizado correctamente.');
    }

    // TOGGLE ESTADO
    public function destroy(Alumno $alumno)
    {
        $alumno->activo = !$alumno->activo;
        $alumno->save();

        return redirect()->route('academica.alumnos.index')->with('success','Estado del alumno actualizado correctamente.');
    }

    // APROBAR INSCRIPCIÓN
    public function aprobar($id)
    {
        $alumno = Alumno::findOrFail($id);

        if($alumno->estado === 'aprobado'){
            return back()->with('error','Este alumno ya fue aprobado.');
        }

        $passwordPlain = Str::random(8);
        $roleAlumno = Role::where('name', 'alumno')->firstOrFail();
        $emailUser = $alumno->dni . '@sigae.local';

        $user = User::create([
            'name' => $alumno->nombre.' '.$alumno->apellido,
            'email' => $emailUser,
            'dni' => $alumno->dni,
            'password' => Hash::make($passwordPlain),
            'role_id' => $roleAlumno->id
        ]);

        $alumno->user_id = $user->id;
        $alumno->estado = 'aprobado';
        $alumno->activo = true;
        $alumno->save();

        return back()->with('success_password', $passwordPlain);
    }

    // RECHAZAR INSCRIPCIÓN
    public function rechazar($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->estado = 'rechazado';
        $alumno->activo = false;
        $alumno->save();

        return back()->with('success','Alumno rechazado. No se creó ningún usuario.');
    }

    // RESUMEN DE ASISTENCIAS
    public function resumen()
    {
        $usuario = Auth::user();
        $alumno = Alumno::where('user_id', $usuario->id)->first();

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $asistenciasMes = AsistenciaAlumno::where('alumno_id', $alumno->id)
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->where('estado', 'presente')
            ->count();

        $totalClases = AsistenciaAlumno::where('alumno_id', $alumno->id)
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->count();

        $porcentaje = $totalClases > 0
            ? round(($asistenciasMes / $totalClases) * 100)
            : 0;

        $ultima = AsistenciaAlumno::where('alumno_id', $alumno->id)
            ->latest('fecha')
            ->first();

        return view('usuario_alumno.resumen.general', compact('asistenciasMes','porcentaje','ultima'));
    }

    // VER DATOS PERSONALES
    public function verDatosPersonales()
    {
        $usuario = Auth::user();
        $alumno = Alumno::with('curso.nivel')->where('user_id', $usuario->id)->first();
        return view('usuario_alumno.informacion.personales', compact('alumno'));
    }
}