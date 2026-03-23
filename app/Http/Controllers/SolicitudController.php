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

    public function verEstado($token)
    {
        $solicitud = Solicitud::where('token', $token)->firstOrFail();

        return view('solicitudes.estado', compact('solicitud'));
    }

    // Aprobar solicitud
    public function aprobar($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        if ($solicitud->estado !== 'pendiente') {
            return back()->with('error', 'La solicitud ya fue procesada.');
        }

        // Crear alumno
        $alumno = Alumno::create([
            'curso_id' => $solicitud->curso_id,
            'nombre' => $solicitud->nombre,
            'apellido' => $solicitud->apellido,
            'dni' => $solicitud->dni,
            'fecha_nacimiento' => $solicitud->fecha_nacimiento,
            'email' => $solicitud->email,
            'anio' => $solicitud->anio,
            'activo' => true,
            'estado' => 'aprobado',
        ]);

        // Generar contraseña aleatoria
        $passwordPlain = Str::random(8);

        // Guardar usuario en la tabla users
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

        // Guardar contraseña temporal en la solicitud para que el alumno la vea
        $solicitud->password_temporal = $passwordPlain;
        $solicitud->estado = 'aprobado';
        $solicitud->save();

        return back()->with('success', 'Alumno aprobado. El alumno podrá ver su contraseña en el link de estado.');
    }
    
    // Rechazar solicitud
    public function rechazar(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->estado = 'rechazado';
        $solicitud->motivo_rechazo = $request->motivo_rechazo; // 🔥 NUEVO
        $solicitud->save();

        return back()->with('success', 'Solicitud rechazada correctamente.');
    }
}