<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Alumno;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SolicitudController extends Controller
{
    // Mostrar solicitudes pendientes
    public function index(Request $request)
    {
        $query = Solicitud::with('curso');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('apellido', 'like', '%' . $request->search . '%')
                ->orWhere('dni', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // SOLO traer pendientes
        $solicitudes = $query->where('estado', 'pendiente')
                            ->orderBy('id', 'desc')
                            ->paginate(10);

        return view('academica.solicitudes.index', compact('solicitudes'));
    }

    // Aprobar solicitud
    public function aprobar($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        // Crear alumno
        $alumno = Alumno::create([
            'curso_id' => $solicitud->curso_id,
            'nombre' => $solicitud->nombre,
            'apellido' => $solicitud->apellido,
            'dni' => $solicitud->dni,
            'email' => $solicitud->email,
            'anio' => $solicitud->anio,
            'activo' => true,
            'estado' => 'aprobado',
        ]);

        // Crear usuario
        $passwordPlain = Str::random(8);
        $roleAlumno = Role::where('name', 'alumno')->firstOrFail();

        $user = User::create([
            'name' => $alumno->nombre.' '.$alumno->apellido,
            'email' => $alumno->email,
            'dni' => $alumno->dni,
            'password' => Hash::make($passwordPlain),
            'role_id' => $roleAlumno->id
        ]);

        $alumno->user_id = $user->id;
        $alumno->save();

        // Cambiar estado de la solicitud a 'aprobado' para historial
        $solicitud->estado = 'aprobado';
        $solicitud->save();

        return back()->with('success', "Alumno aprobado y usuario creado. Contraseña: $passwordPlain");
    }
    
    // Rechazar solicitud
    public function rechazar($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado = 'rechazado';
        $solicitud->save();

        return back()->with('success', 'Solicitud rechazada. No se creó ningún alumno.');
    }
}