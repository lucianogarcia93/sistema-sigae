<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\AsistenciaAlumno;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaAlumnoController extends Controller
{
    /*
    |---------------------------------------
    | INDEX
    |---------------------------------------
    */
    public function index(Request $request)
    {
        $cursos = Curso::with('nivel')
            ->where('activo',1)
            ->orderBy('division')
            ->get();

        $planillas = AsistenciaAlumno::with('curso')
            ->select('curso_id','fecha','anio', DB::raw('count(*) as total'))
            ->groupBy('curso_id','fecha','anio')
            ->orderBy('fecha','desc')
            ->get();

        $errorAlumnos = null;

        if($request->filled('curso_id') && $request->filled('anio')) {
            $alumnos = Alumno::where('curso_id', $request->curso_id)
                ->where('anio', $request->anio)
                ->where('activo',1)
                ->count();

            if($alumnos === 0) {
                $errorAlumnos = "El curso o año escolar seleccionado no posee alumnos.";
            }
        }

        return view('asistencia.asistencia_alumno.index', compact('cursos','planillas','errorAlumnos'));
    }

    public function cargarPlanilla(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'anio' => 'required|integer',
            'fecha' => 'required|date'
        ]);

        $alumnos = Alumno::where('curso_id', $request->curso_id)
                        ->where('anio', $request->anio)
                        ->where('activo',1)
                        ->count();

        if($alumnos === 0){
            return redirect()->route('asistencia.asistencia_alumno.index')
                            ->with('error', 'El curso o año escolar seleccionado no posee alumnos.');
        }

        // 🔹 Revisar si ya existe planilla
        $existe = AsistenciaAlumno::where('curso_id', $request->curso_id)
                    ->where('fecha', $request->fecha)
                    ->where('anio', $request->anio)
                    ->exists();

        if($existe){
            // Redirigir a solo lectura
            return redirect()->route('asistencia.asistencia_alumno.edit', $request->only('curso_id','anio','fecha'));
        }

        // Si no existe, ir a create para cargar planilla nueva
        return redirect()->route('asistencia.asistencia_alumno.create', $request->only('curso_id','anio','fecha'));
    }

    /*
    |---------------------------------------
    | CREATE
    |---------------------------------------
    */
    public function create(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'fecha' => 'required|date',
            'anio' => 'required|integer'
        ]);

        $curso = Curso::findOrFail($request->curso_id);
        $fecha = $request->fecha;
        $anio = $request->anio;

        if(Carbon::parse($fecha)->gt(Carbon::today())){
            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('error','No se puede cargar asistencia para fechas futuras.');
        }

        $existe = AsistenciaAlumno::where('curso_id',$curso->id)
            ->where('fecha',$fecha)
            ->where('anio',$anio) // 🔹 filtrar por año
            ->exists();

        if($existe){
            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('error','Ya existe una planilla de asistencia para este curso en esa fecha y año.');
        }

        $alumnos = Alumno::where('curso_id',$curso->id)
            ->where('anio',$anio) // 🔹 filtrar por año
            ->where('activo',1)
            ->orderBy('apellido')
            ->get();

        return view('asistencia.asistencia_alumno.create',
            compact('curso','fecha','alumnos','anio'));
    }

    /*
    |---------------------------------------
    | STORE
    |---------------------------------------
    */
    public function store(Request $request)
    {
        $fecha = $request->fecha;
        $anio = $request->anio;

        if(Carbon::parse($fecha)->gt(Carbon::today())){
            return redirect()
                ->back()
                ->withInput()
                ->with('error','No se puede cargar asistencia para fechas futuras.');
        }

        $request->validate([
            'curso_id'=>'required|exists:cursos,id',
            'fecha'=>'required|date',
            'anio'=>'required|integer',
            'asistencias'=>'required|array'
        ]);

        if(count($request->asistencias) == 0){
            return back()->withInput()->with('error','Debe ingresar al menos una asistencia.');
        }

        DB::beginTransaction();

        try {

            foreach($request->asistencias as $alumno_id=>$estado){

                AsistenciaAlumno::create([
                    'alumno_id'=>$alumno_id,
                    'curso_id'=>$request->curso_id,
                    'fecha'=>$fecha,
                    'anio'=>$anio, // 🔹 guardar año
                    'estado'=>$estado
                ]);
            }

            DB::commit();

            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('success','Asistencia registrada correctamente');

        } catch(\Exception $e){

            DB::rollBack();

            return back()->with('error','Error al guardar asistencia');
        }
    }

    /*
    |---------------------------------------
    | EDIT
    |---------------------------------------
    */
    public function edit(Request $request)
    {
        $curso_id = $request->curso_id;
        $fecha = $request->fecha;

        // Traemos el curso
        $curso = Curso::findOrFail($curso_id);

        // Traemos las asistencias con los alumnos y ordenamos por apellido en PHP
        $asistencias = AsistenciaAlumno::where('curso_id', $curso_id)
                        ->where('fecha', $fecha)
                        ->with('alumno') // importante para acceder al alumno
                        ->get()
                        ->sortBy(fn($a) => $a->alumno->apellido); // ordena en memoria

        return view('asistencia.asistencia_alumno.edit', compact('curso', 'fecha', 'asistencias'));
    }

    /*
    |---------------------------------------
    | UPDATE
    |---------------------------------------
    */
    public function update(Request $request)
    {
        $request->validate([
            'curso_id'=>'required|exists:cursos,id',
            'fecha'=>'required|date',
            'anio'=>'required|integer',
            'asistencias'=>'required|array'
        ]);

        DB::beginTransaction();

        try {

            foreach($request->asistencias as $alumno_id=>$estado){

                AsistenciaAlumno::where('alumno_id',$alumno_id)
                    ->where('curso_id',$request->curso_id)
                    ->where('fecha',$request->fecha)
                    ->where('anio',$request->anio) // 🔹 filtrar por año
                    ->update([
                        'estado'=>$estado
                    ]);
            }

            DB::commit();

            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('success','Asistencia actualizada correctamente');

        } catch(\Exception $e){

            DB::rollBack();

            return back()->with('error','Error al actualizar asistencia');
        }
    }

    /*
    |---------------------------------------
    | HISTORIAL ASISTENCIAS ALUMNO LOGUEADO
    |---------------------------------------
    */
    public function historialAlumno(Request $request)
    {
        $user = auth()->user();

        $alumno = Alumno::where('user_id', $user->id)->first();

        if(!$alumno){
            return back()->with('error','No se encontró el alumno');
        }

        $mes = $request->query('mes');

        $asistencias = AsistenciaAlumno::where('alumno_id',$alumno->id)
            ->when($mes, function($query, $mes){

                $parts = explode('-', $mes);

                if(count($parts) == 2){
                    $query->whereMonth('fecha',$parts[1])
                        ->whereYear('fecha',$parts[0]);
                }

            })
            ->orderBy('fecha','desc')
            ->get();

        return view('usuario_alumno.total_asistencias.historial',
            compact('asistencias','mes'));
    }
}