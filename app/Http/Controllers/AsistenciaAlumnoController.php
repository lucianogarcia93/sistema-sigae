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
    public function index()
    {
        $cursos = Curso::with('nivel')
            ->where('activo',1)
            ->orderBy('division')
            ->get();

        $planillas = AsistenciaAlumno::with('curso')
            ->select(
                'curso_id',
                'fecha',
                DB::raw('count(*) as total')
            )
            ->groupBy('curso_id','fecha')
            ->orderBy('fecha','desc')
            ->get();

        return view('asistencia.asistencia_alumno.index',
            compact('cursos','planillas'));
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
            'fecha' => 'required|date'
        ]);

        $curso = Curso::findOrFail($request->curso_id);
        $fecha = $request->fecha;

        // 🚫 bloquear fechas futuras
        if(Carbon::parse($fecha)->gt(Carbon::today())){
            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('error','No se puede cargar asistencia para fechas futuras.');
        }

        $existe = AsistenciaAlumno::where('curso_id',$curso->id)
            ->where('fecha',$fecha)
            ->exists();

        if($existe){
            return redirect()
                ->route('asistencia.asistencia_alumno.index')
                ->with('error','Ya existe una planilla de asistencia para este curso en esa fecha.');
        }

        $alumnos = Alumno::where('curso_id',$curso->id)
            ->where('activo',1)
            ->orderBy('apellido')
            ->get();

        return view('asistencia.asistencia_alumno.create',
            compact('curso','fecha','alumnos'));
    }

    /*
    |---------------------------------------
    | STORE
    |---------------------------------------
    */
    public function store(Request $request)
    {
        $fecha = $request->fecha;

        if(Carbon::parse($fecha)->gt(Carbon::today())){
            return redirect()
                ->back()
                ->withInput()
                ->with('error','No se puede cargar asistencia para fechas futuras.');
        }

        $request->validate([
            'curso_id'=>'required|exists:cursos,id',
            'fecha'=>'required|date',
            'asistencias'=>'required|array'
        ]);

        DB::beginTransaction();

        try {

            foreach($request->asistencias as $alumno_id=>$estado){

                AsistenciaAlumno::create([
                    'alumno_id'=>$alumno_id,
                    'curso_id'=>$request->curso_id,
                    'fecha'=>$request->fecha,
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
        $request->validate([
            'curso_id'=>'required|exists:cursos,id',
            'fecha'=>'required|date'
        ]);

        $curso = Curso::findOrFail($request->curso_id);
        $fecha = $request->fecha;

        $asistencias = AsistenciaAlumno::with('alumno')
            ->where('curso_id',$curso->id)
            ->where('fecha',$fecha)
            ->get();

        return view('asistencia.asistencia_alumno.edit',
            compact('curso','fecha','asistencias'));
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
            'asistencias'=>'required|array'
        ]);

        DB::beginTransaction();

        try {

            foreach($request->asistencias as $alumno_id=>$estado){

                AsistenciaAlumno::where('alumno_id',$alumno_id)
                    ->where('curso_id',$request->curso_id)
                    ->where('fecha',$request->fecha)
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